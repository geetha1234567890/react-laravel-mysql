import React, { useEffect, useState } from "react";
import {
  Button,
  IconButton,
  Switch,
  Pagination,
  Box,
  Checkbox,
} from "@mui/material";
import DeleteOutlineOutlinedIcon from "@mui/icons-material/DeleteOutlineOutlined";
import CallMadeOutlinedIcon from "@mui/icons-material/CallMadeOutlined";
import ModeEditOutlineOutlinedIcon from "@mui/icons-material/ModeEditOutlineOutlined";
import { styled } from "@mui/material/styles";
import "./DynamicTable.css";
import { useNavigate } from "react-router-dom";
import editIcon from "../../assets/editIcon.png";
import bin from "../../assets/bin.png";
import CalendarMonthIcon from "@mui/icons-material/CalendarMonth";
import { useDispatch } from "react-redux";
import { updateTA } from "../../redux/features/taModule/taSlice";
import { openScheduleSession } from "../../redux/features/taModule/taScheduling";

const CustomButton = styled(Button)(({ theme }) => ({
  borderRadius: "20px",
  border: "1px solid #F56D3B",
  color: "#F56D3B",
  padding: "8px 16px", // Add padding for horizontal and vertical spacing
  margin: "0 8px", // Add horizontal margin between buttons
  "&:hover": {
    backgroundColor: "#F56D3B",
    color: "#fff",
    borderColor: "#F56D3B",
  },
  "&.active": {
    backgroundColor: "#F56D3B",
    color: "#fff",
  },
}));

const CalenderButton = styled(Button)(({ theme }) => ({
  borderRadius: "20px",
  border: "none",
  color: "#F56D3B",
  backgroundColor: "#FEEBE3",
  transition: "all 0.3s ease", // Corrected transition syntax
  "&:hover": {
    backgroundColor: "#FEEBE3",
    color: "#F56D3B",
    border: "none", // Corrected border removal syntax
  },
  "&:focus": {
    outline: "none", // Remove default focus outline if desired
  },
}));

const AntSwitch = styled(Switch)(({ theme }) => ({
  width: 36, // adjust width as needed
  height: 20, // increased height
  padding: 0,
  marginTop: 5,
  display: "flex",
  "&:active": {
    "& .MuiSwitch-thumb": {
      width: 17, // adjust width to keep thumb proportional
    },
    "& .MuiSwitch-switchBase.Mui-checked": {
      transform: "translateX(16px)", // adjust translation to match increased height
    },
  },
  "& .MuiSwitch-switchBase": {
    padding: 3, // increased padding for larger height
    "&.Mui-checked": {
      transform: "translateX(18px)", // adjust translation to match increased height
      color: "#fff",
      "& + .MuiSwitch-track": {
        opacity: 1,
        backgroundColor: theme.palette.mode === "dark" ? "#177ddc" : "#14D249",
      },
    },
  },
  "& .MuiSwitch-thumb": {
    boxShadow: "0 2px 4px 0 rgb(0 35 11 / 20%)",
    width: 14, // increased width for larger thumb
    height: 14, // increased height for larger thumb
    borderRadius: 7, // adjusted to keep thumb circular
    transition: theme.transitions.create(["width"], {
      duration: 200,
    }),
  },
  "& .MuiSwitch-track": {
    borderRadius: 20 / 2, // adjusted to match new height
    opacity: 1,
    backgroundColor:
      theme.palette.mode === "dark"
        ? "rgba(255,255,255,.35)"
        : "rgba(0,0,0,.25)",
    boxSizing: "border-box",
  },
}));

const DynamicTable = ({
  headers,
  initialData,
  actionButtons,
  componentName,
}) => {
  const [data, setData] = useState(
    initialData.map((item) => ({
      ...item,
      is_active: item.is_active !== undefined ? item.is_active : 0,
    }))
  );

  useEffect(() => {
    setData(
      initialData.map((item) => ({
        ...item,
        is_active: item.is_active !== undefined ? item.is_active : 0,
      }))
    );
  }, [initialData]);

  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 10;
  const totalPages = Math.ceil(data.length / itemsPerPage);
  const currentData = data.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );
  const navigate = useNavigate();
  const dispatch = useDispatch();
// console.log("componentName", componentName);
  const handlePageChange = (event, pageNumber) => {
    setCurrentPage(pageNumber);
  };

  const handleDelete = (id) => {
    console.log("Deleting item with id:", id);
  };

  const handleView = (type, id) => {
    // console.log("ID handleview : ", id);
    console.log("component name is",componentName);
    if(componentName=== "TAMAPPING"){
    if (type === "students") {
      navigate(`/active-students/${id}`); // Append id as a parameter
    } else if (type === "batches") {
      navigate(`/active-batches/${id}`); // Append id as a parameter
    } else if (type === "view report") {
      navigate(`/view-report/${id}`); // Append id as a parameter
    }
  }else{
    if (type === "students") {
      navigate(`/active-Coach-students/${id}`); // Append id as a parameter
    } else if (type === "batches") {
      navigate(`/active-Coach-batches/${id}`); // Append id as a parameter
    }
  }
  };

  const handlePopup = (id, name) => {
    console.log("ID handlePopup : ", id, name);
    const data = {
      id, name
    }
    dispatch(openScheduleSession(data));
  }

  const handleToggle = (id) => {
    console.log("id : ", id);
    const updatedData = data.map((item) =>
      item.id === id
        ? { ...item, is_active: item.is_active === 1 ? 0 : 1 }
        : item
    );
    setData(updatedData);

    const toggledItem = updatedData.find((item) => item.id === id);
    const requestData = { is_active: toggledItem.is_active };

    switch (componentName) {
      case "MANAGETA":
        dispatch(updateTA({ id, data: requestData }));
        break;
      case "TAMAPPING":
        console.log("TA MAPPING : ", id, requestData);
        // dispatch(updateTA({ id, data: requestData }));
        break;
      default:
        console.warn(`No API call defined for component: ${componentName}`);
        break;
    }
  };

  const getColorForAvailability = (availability) => {
    switch (availability) {
      case "Active":
        return "#06DD0F";
      case "On Leave":
        return "#F48606";
      case "Inactive":
        return "#808080";
      default:
        return "#000000";
    }
  };
  return (
    <div className="tableContainer">
      <table>
        <thead className="tableHead">
          <tr>
            {headers.map((header, index) => (
              <th key={index}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody className="tableBody">
          {currentData.length === 0 ? (
            <tr>
              <td colSpan={headers.length} style={{ textAlign: "center" }}>
                No Data Available
              </td>
            </tr>
          ) : (
            currentData.map((item, index) => (
              <tr key={item.id} id="tableRow">
                {/* {console.log("CUURENT : ", item)} */}
                <td>{(currentPage - 1) * itemsPerPage + index + 1}</td>
                {Object.keys(item).map((key, idx) => {
                  // {console.log("KEY : ", key)}
                  if (key === "Active_Students") {
                    return (
                      <td key={idx}>
                        {item[key]}{" "}
                        <CustomButton
                          variant="outlined"
                          color="secondary"
                          endIcon={<CallMadeOutlinedIcon />}
                          onClick={() => handleView("students", item.id)}
                        >
                          View
                        </CustomButton>
                      </td>
                    );
                  } else if (key === "Active_Batches") {
                    return (
                      <td key={idx}>
                        {item[key]}{" "}
                        <CustomButton
                          variant="outlined"
                          color="secondary"
                          endIcon={<CallMadeOutlinedIcon />}
                          onClick={() => handleView("batches", item.id)}
                        >
                          View
                        </CustomButton>
                      </td>
                    );
                  } else if (key !== "id" && key !== "is_active") {
                    // Check if item[key] is an object, and handle accordingly
                    if (typeof item[key] === "object" && item[key] !== null) {
                      // Render a string representation or a relevant property of the object
                      return <td key={idx}>{JSON.stringify(item[key])}</td>;
                    } else {
                      return <td key={idx}>{item[key]}</td>;
                    }
                  }
                  return null; // Ensure all paths return a value
                })}

                {actionButtons && (
                  <td
                    style={{
                      display: "flex",
                      justifyContent: "center",
                      verticalAlign: "middle",
                    }}
                  >
                    {actionButtons.map((button, idx) => {
                      if (button.type === "switch") {
                        return (
                          <AntSwitch
                            key={idx}
                            checked={item.is_active}
                            onChange={() => handleToggle(item.id)}
                            inputProps={{ "aria-label": "ant design" }}
                          />
                        );
                      }
                      if (button.type === "edit") {
                        return (
                          <IconButton
                            key={idx}
                            color="primary"
                            sx={{
                              marginLeft: "10px",
                              display: "flex",
                              alignItems: "center",
                              justifyContent: "center",
                              color: "#F56D3B",
                              backgroundColor: "#FEEBE3",
                              gap: "4px",
                              height: "30px",
                              width: "70px",
                              borderRadius: "15px",
                              padding: "5px",
                              "&:hover": {
                                backgroundColor: "rgba(245, 235, 227, 0.8)",
                              },
                              "& img": {
                                height: "16px", // adjust size as needed
                                width: "16px", // adjust size as needed
                              },
                              "& small": {
                                lineHeight: "16px", // match this with the image height for better alignment
                              },
                            }}
                            onClick={() => button.onClick(item.id)}
                          >
                            <img src={editIcon} alt="" />
                            <small style={{ fontSize: "14px" }}>Edit</small>
                          </IconButton>
                        );
                      }
                      if (button.type === "delete") {
                        return (
                          <IconButton
                            key={idx}
                            color="primary"
                            onClick={() => handleDelete(item.id)}
                          >
                            <img
                              src={bin}
                              alt=""
                              style={{ width: "20px", height: "20px" }}
                            />
                          </IconButton>
                        );
                      }
                      if (button.type === "calendar") {
                        return (
                          <CalenderButton
                            key={idx}
                            variant="outlined"
                            color="secondary"
                            startIcon={<CalendarMonthIcon />}
                            onClick={() => handlePopup(item.id, item.name)}
                          >
                            Schedule
                          </CalenderButton>
                        );
                      }

                      if (button.type === "view") {
                        return (
                          <CustomButton
                            key={idx}
                            variant="outlined"
                            color="secondary"
                            endIcon={<CallMadeOutlinedIcon />}
                            onClick={() => handleView("view report", item.id)}
                          >
                            View
                          </CustomButton>
                        );
                      }
                      return null; // Handle unexpected button types gracefully
                    })}
                  </td>
                )}
              </tr>
            ))
          )}
        </tbody>
      </table>
      <div className="pagination">
        <Pagination
          count={totalPages}
          page={currentPage}
          onChange={handlePageChange}
          variant="outlined"
          color="primary"
          sx={{
            width: "65vw",
            display: "flex",
            justifyContent: "center",
            marginTop: "20px",
            ".MuiPaginationItem-root": {
              backgroundColor: "#fff",
              border: "1px solid #ddd",
              borderRadius: "50%",
              width: "40px",
              height: "40px",
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              transition: "background-color 0.3s, transform 0.3s",
              "&:hover": {
                backgroundColor: "#DFDFF4",
                transform: "scale(1.1)",
              },
              "&.Mui-selected": {
                backgroundColor: "#F56D3B",
                color: "#fff",
              },
              "&.Mui-disabled": {
                backgroundColor: "#DFDFF4",
                cursor: "not-allowed",
              },
            },
          }}
        />
      </div>
    </div>
  );
};

export default DynamicTable;
