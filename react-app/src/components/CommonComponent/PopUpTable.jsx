import React, { useEffect, useState } from "react";
import { IconButton, Checkbox, Button } from "@mui/material";
import "./popUpTable.css";
import { useNavigate } from "react-router-dom";
import editIcon from "../../assets/editIcon.png";
import bin from "../../assets/bin.png";

const CustomButton = ({ onClick, children, variant = 'contained', color = '#FFFFFF', backgroundColor = '#4E18A5', borderColor = '#FFFFFF', sx, ...props }) => {
  const variantStyles = {
    contained: {
      backgroundColor: backgroundColor,
      color: color,
      border: `2px solid ${borderColor}`,
      '&:hover': {
        backgroundColor: color,
        color: backgroundColor,
        borderColor: borderColor,
      },
    },
    outlined: {
      backgroundColor: 'transparent',
      color: '#F56D38',
      border: '2px solid #F56D38',
      '&:hover': {
        backgroundColor: '#F56D38',
        color: '#FFFFFF',
      },
    },
    text: {
      backgroundColor: 'transparent',
      color: '#F56D38',
      '&:hover': {
        backgroundColor: '#F56D38',
        color: '#FFFFFF',
      },
    },
  };

  return (
    <Button
      onClick={onClick}
      variant={variant}
      sx={{
        ...variantStyles[variant],
        fontWeight: '700',
        fontSize: '16px',
        borderRadius: '50px',
        padding: '10px 20px',
        ...sx,
      }}
      {...props}
    >
      {children}
    </Button>
  );
};


const PopUpTable = ({ headers, initialData, onRowClick, selectedBox = [] ,onViewClick, onRescheduleClick, onCancelClick, itemsPerPage = 4}) => {
  const [data, setData] = useState(initialData ?? []);
  // console.log("INTIAL DATA : ", data)
  useEffect(() => {
    setData(initialData ?? []);
  }, [initialData]);

  const handleCheckboxChange = (id) => {
    onRowClick(id);
  };

  const [currentPage, setCurrentPage] = useState(1);
  const totalPages = Math.ceil(data.length / itemsPerPage);
  const currentData = data.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <div className="table-container popUpModel">
      <table>
        <thead>
          <tr>
            {headers.map((header, index) => (
              <th key={index}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody className="popUpBody">
          {currentData.map((item, index) => (
            <tr key={item["S. No."] ?? index} id="popUpRow">
              {/* {console.log("DATA : ",item)} */}
              {headers.map((header, idx) => (
                <td key={idx}>
                  {header === "Select" ? (
                    <Checkbox
                      checked={selectedBox.includes(item["S. No."])}
                      onChange={() => handleCheckboxChange(item["S. No."])}
                      sx={{
                        "& .MuiSvgIcon-root": {
                          color: "#C2C2E7", // Color for the tick
                        },
                      }}
                      inputProps={{ "aria-label": "select all" }}
                    />
                  ) : header === "Actions" ? (
                    <div>
                      <CustomButton
                        backgroundColor="#F56D38"
                        color="#FFFFFF"
                        borderColor="#F56D38"
                        variant="contained"
                        onClick={() => onCancelClick(item)}
                      >
                        Cancel
                      </CustomButton>
                      <div
                        style={{
                          textDecoration: "underline",
                          cursor: "pointer",
                          marginTop: "4px",
                          color: "#F56D3B",
                        }}
                        onClick={() => onRescheduleClick(item)}
                      >
                        Reschedule
                      </div>
                    </div>
                  ) : header === "Students" ? (
                    <>
                      {item.Students}
                      <CustomButton
                        variant="outlined"
                        backgroundColor="#FFFFFF"
                        borderColor="#F56D38"
                        color="#F56D38"
                        onClick={() => onViewClick(item.StudentList)}
                      >
                        View
                      </CustomButton>
                    </>
                  ) : (
                    item[header] ?? "N/A"
                  )}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default PopUpTable;
