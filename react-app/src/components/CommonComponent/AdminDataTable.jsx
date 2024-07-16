import React, { useEffect, useState } from "react";
import { Button, IconButton, Switch, Pagination, Box } from "@mui/material";
import DeleteOutlineOutlinedIcon from "@mui/icons-material/DeleteOutlineOutlined";
import ModeEditOutlineOutlinedIcon from "@mui/icons-material/ModeEditOutlineOutlined";
import { styled } from "@mui/material/styles";

import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import ArrowBackIosIcon from "@mui/icons-material/ArrowBackIos";
import { useLocation, useNavigate, useParams } from "react-router-dom";
import { AssignedBatchesData } from "../../fakeData/AssignedBatchesData";
import bin from "../../assets/bin.png";
import { useDispatch, useSelector } from "react-redux";

const CustomButton = styled(Button)(({ theme, active }) => ({
  borderRadius: "50px",
  border: "1px solid #F56D3B",
  color: active ? "#fff" : "#F56D3B",
  backgroundColor: active ? "#F56D3B" : "#FFF",
  padding: "8px 16px",
  margin: "0 8px",
  "&:hover": {
    backgroundColor: "#F56D3B",
    color: "#fff",
    borderColor: "#F56D3B",
  },
}));

const AntSwitch = styled(Switch)(({ theme }) => ({
  width: 28,
  height: 16,
  padding: 0,
  marginTop: 12,
  display: "flex",
  "&:active": {
    "& .MuiSwitch-thumb": {
      width: 15,
    },
    "& .MuiSwitch-switchBase.Mui-checked": {
      transform: "translateX(9px)",
    },
  },
  "& .MuiSwitch-switchBase": {
    padding: 2,
    "&.Mui-checked": {
      transform: "translateX(12px)",
      color: "#fff",
      "& + .MuiSwitch-track": {
        opacity: 1,
        backgroundColor: theme.palette.mode === "dark" ? "#177ddc" : "#14D249",
      },
    },
  },
  "& .MuiSwitch-thumb": {
    boxShadow: "0 2px 4px 0 rgb(0 35 11 / 20%)",
    width: 12,
    height: 12,
    borderRadius: 6,
    transition: theme.transitions.create(["width"], {
      duration: 200,
    }),
  },
  "& .MuiSwitch-track": {
    borderRadius: 16 / 2,
    opacity: 1,
    backgroundColor:
      theme.palette.mode === "dark"
        ? "rgba(255,255,255,.35)"
        : "rgba(0,0,0,.25)",
    boxSizing: "border-box",
  },
}));

const AdminDataTable = ({
  headers,
  initialData,
  title,
  actionButtons,
  ta_id,
  dispatch,
}) => {
    console.log("initial data", initialData)
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

  const handlePageChange = (event, pageNumber) => {
    setCurrentPage(pageNumber);
  };

  const handleToggle = (id) => {
    const updatedData = data.map((item) =>
      item.id === id
        ? { ...item, is_active: item.is_active === 1 ? 0 : 1 }
        : item
    );
    setData(updatedData);

    const toggledItem = updatedData.find((item) => item.id === id);
    const requestData = { is_active: toggledItem.is_active };
    dispatch(toggleAssignStudentStatus({ id, data: requestData }));
  };

  const handleDelete = (id) => {
    dispatch(deleteAssignedStudent({ id }));
  };

  const handleNavigate = (path) => {
    navigate(path);
  };

  return (
    <div className="table-container">
      <Box display={"flex"} justifyContent={"space-between"}>
        <Box display="flex" alignItems="center" padding="16px">
          <ArrowBackIosIcon
            style={{ fontSize: "25px", marginBottom: "17px" }}
            onClick={() => navigate("/ta-mapping")}
          />

          <p
            style={{
              fontSize: "44px",
              marginLeft: "16px",
            }}
          >
            {title}
          </p>
        </Box>
        <div className="inputBtnContainer">
          <CustomButton
            onClick={() => handleNavigate(`/active-students/${ta_id}`)}
            active={location.pathname === `/active-students/${ta_id}`}
          >
            Assigned Student
          </CustomButton>
          <CustomButton
            onClick={() => handleNavigate(`/active-batches/${ta_id}`)}
            active={location.pathname === `/active-batches/${ta_id}`}
          >
            Assigned Batches
          </CustomButton>
        </div>
      </Box>
      <table>
        <thead className="commonTableHead">
          <tr>
            {headers.map((header, index) => (
              <th key={index}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody className="commonTableBody">
          {currentData.map((item, index) => (
            <tr key={item.id} id="commonTableRow">
              <td>{(currentPage - 1) * itemsPerPage + index + 1}</td>
              {Object.keys(item).map((key, idx) => {
                if (key !== "id" && key !== "is_active") {
                  return <td key={idx}>{item[key]}</td>;
                }
                return null;
              })}
              {actionButtons && (
                <td
                  style={{
                    display: "flex",
                    justifyContent: "center",
                    verticalAlign: "middle",
                  }}
                >
                  {actionButtons?.map((button, idx) => {
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
                          onClick={() => button.onClick(item.id)}
                        >
                          <ModeEditOutlineOutlinedIcon />
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
                    return null;
                  })}
                </td>
              )}
            </tr>
          ))}
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

export default AdminDataTable;
