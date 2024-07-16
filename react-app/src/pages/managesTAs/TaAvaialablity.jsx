import React, { useState } from "react";
import { Button, IconButton, Switch, Pagination, Box } from "@mui/material";
import DeleteOutlineOutlinedIcon from '@mui/icons-material/DeleteOutlineOutlined';
import CallMadeOutlinedIcon from '@mui/icons-material/CallMadeOutlined';
import ModeEditOutlineOutlinedIcon from '@mui/icons-material/ModeEditOutlineOutlined';
import { styled } from "@mui/material/styles";
import './CommonComponent.css'
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import { mockDataAvilable } from "../../fakeData/availableData";
import { useNavigate } from 'react-router-dom';

const CustomButton = styled(Button)(({ theme }) => ({
    borderRadius: '20px',
    border: "1px solid #F56D3B",
    color: "#F56D3B",
    '&:hover': {
        backgroundColor: "#F56D3B",
        color: '#fff',
        borderColor: '#F56D3B',
    },
}));

const AntSwitch = styled(Switch)(({ theme }) => ({
    width: 28,
    height: 16,
    padding: 0,
    marginTop: 12,
    display: 'flex',
    '&:active': {
        '& .MuiSwitch-thumb': {
            width: 15,
        },
        '& .MuiSwitch-switchBase.Mui-checked': {
            transform: 'translateX(9px)',
        },
    },
    '& .MuiSwitch-switchBase': {
        padding: 2,
        '&.Mui-checked': {
            transform: 'translateX(12px)',
            color: '#fff',
            '& + .MuiSwitch-track': {
                opacity: 1,
                backgroundColor: theme.palette.mode === 'dark' ? '#177ddc' : '#14D249',
            },
        },
    },
    '& .MuiSwitch-thumb': {
        boxShadow: '0 2px 4px 0 rgb(0 35 11 / 20%)',
        width: 12,
        height: 12,
        borderRadius: 6,
        transition: theme.transitions.create(['width'], {
            duration: 200,
        }),
    },
    '& .MuiSwitch-track': {
        borderRadius: 16 / 2,
        opacity: 1,
        backgroundColor:
            theme.palette.mode === 'dark' ? 'rgba(255,255,255,.35)' : 'rgba(0,0,0,.25)',
        boxSizing: 'border-box',
    },
}));

const DynamicTable = ({ headers, initialData, title, actionButtons }) => {
    const navigate = useNavigate()
    const [data, setData] = useState(initialData.map(item => ({
        ...item,
        isActive: item.isActive !== undefined ? item.isActive : false,
    })));
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 10;
    const totalPages = Math.ceil(data.length / itemsPerPage);
    const currentData = data.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

    const handlePageChange = (event, pageNumber) => {
        setCurrentPage(pageNumber);
    };

    const handleToggle = (id) => {
        setData(prevData =>
            prevData.map(item =>
                item.id === id ? { ...item, isActive: !item.isActive } : item
            )
        );
    };

    const handleDelete = (id) => {
        // Implement delete functionality here
        console.log("Deleting item with id:", id);
    };

    const handleView = (type, id, taName) => {
     
        // Implement view functionality here based on type ('students' or 'batches')

        console.log(`Viewing ${type} for item with id:`, id);
        navigate(`/ta-calendar/${taName}/${id}`)
    };

    const getColorForAvailability = (availability) => {
        switch (availability) {
            case 'Active':
                return '#06DD0F';
            case 'On Leave':
                return '#F48606';
            case 'Inactive':
                return '#808080';
            default:
                return '#000000';
        }
    };

    return (
        <div className="table-container">
            <Box display={"flex"} justifyContent={"space-between"}>
                <p style={{ fontSize: "44px", justifyContent: "center", marginBottom: '20px' , fontFamily:"ExtraLight", letterSpacing:"0.8px" }}>{title}</p>
            </Box>
            <table>
                <thead className="commonTableHead">
                    <tr>
                        {headers.map((header, index) => (
                            <th style={{fontFamily:"Medium", letterSpacing:"0.8px"}} key={index}>{header}</th>
                        ))}
                        {/* <th>Actions</th> Add an extra header for actions */}
                    </tr>
                </thead>
                <tbody className="commonTableBody">
                    {currentData.map((item, index) => (
                        <tr key={item.id} id="commonTableRow">
                            {/* {console.log("ITEM : ", item)} */}
                            <td style={{fontFamily:"Regular", letterSpacing:"0.8px"}}>{(currentPage - 1) * itemsPerPage + index + 1}</td>
                            {Object.keys(item).map((key, idx) => {
                                if (key === 'availability') {
                                    return (
                                        <td key={idx} style={{ color: getColorForAvailability(item[key]) ,fontFamily:"Regular", letterSpacing:"0.8px" }}>
                                            {item[key]}
                                        </td>
                                    );
                                } else if (key === 'calendar') {
                                    return (
                                        <td key={idx} style={{fontFamily:"Regular", letterSpacing:"0.8px"}}>
                                            {/* {item[key]}{" "} */}
                                            <CustomButton
                                                variant="outlined"
                                                color="secondary"
                                                endIcon={<CallMadeOutlinedIcon />}
                                                onClick={() => handleView('Calendar', item.id, item.taName)}
                                            >
                                                Check
                                            </CustomButton>
                                        </td>
                                    );

                                } else if (key !== 'id' && key !== 'isActive') {
                                    return <td style={{fontFamily:"Regular", letterSpacing:"0.8px"}} key={idx}>{item[key]}</td>;
                                }
                                return null;
                            })}
                            {
                                actionButtons && <td style={{ display: "flex", justifyContent: "center", verticalAlign: "middle", fontFamily:"Regular", letterSpacing:"0.8px"}}>
                                    {actionButtons?.map((button, idx) => {
                                        if (button.type === 'switch') {
                                            return (
                                                <AntSwitch
                                                    key={idx}
                                                    checked={item.isActive}
                                                    onChange={() => handleToggle(item.id)}
                                                    inputProps={{ 'aria-label': 'ant design' }}
                                                />
                                            );
                                        }
                                        if (button.type === 'edit') {
                                            return (
                                                <IconButton key={idx} color="primary" onClick={() => button.onClick(item.id)}>
                                                    <ModeEditOutlineOutlinedIcon />
                                                </IconButton>
                                            );
                                        }
                                        if (button.type === 'delete') {
                                            return (
                                                <IconButton key={idx} color="primary" onClick={() => handleDelete(item.id)}>
                                                    <DeleteOutlineOutlinedIcon style={{ color: "#FF0000" }} />
                                                </IconButton>
                                            );
                                        }
                                        return null;
                                    })}
                                </td>
                            }

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
                        width: '65vw',
                        display: 'flex',
                        justifyContent: 'center',
                        marginTop: '20px',
                        '.MuiPaginationItem-root': {
                            backgroundColor: '#fff',
                            border: '1px solid #ddd',
                            borderRadius: '50%',
                            width: '40px',
                            height: '40px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            transition: 'background-color 0.3s, transform 0.3s',
                            '&:hover': {
                                backgroundColor: '#DFDFF4',
                                transform: 'scale(1.1)',
                            },
                            '&.Mui-selected': {
                                backgroundColor: '#F56D3B',
                                color: '#fff',
                            },
                            '&.Mui-disabled': {
                                backgroundColor: '#DFDFF4',
                                cursor: 'not-allowed',
                            },
                        },
                    }}
                />
            </div>
        </div>
    );
};


const headers = ["Sr. No.", "TA Name", "Username", "Availability", "Calendar"];



const TaAvialability = () => {
  
    return (
        <>
            <Header />
            <Sidebar />
            <DynamicTable
                headers={headers}
                initialData={mockDataAvilable}
                title="TA Availability"
            />
        </>
    );
};

export { DynamicTable }; 
export default TaAvialability; 





