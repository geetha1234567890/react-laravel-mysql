import React, { useState } from "react";
import "./TableMapping.css";
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import { Button, IconButton, Switch, Pagination, Box } from "@mui/material";
import DeleteOutlineOutlinedIcon from '@mui/icons-material/DeleteOutlineOutlined';
import CallMadeOutlinedIcon from '@mui/icons-material/CallMadeOutlined';
import { styled } from "@mui/material/styles";

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
const initialData = [
    { id: 1, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 2, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 3, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 4, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 5, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 6, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 7, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 8, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 9, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 10, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 11, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 12, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 13, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 14, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 15, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 16, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 17, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 18, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 19, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
    { id: 20, taName: "Name Here", username: "Lorem Ipsum", activeStudents: 6, activeBatches: 3, isActive: true },
];

const itemsPerPage = 10;

const TableMapping = () => {
    const [data, setData] = useState(initialData);
    const [currentPage, setCurrentPage] = useState(1);

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

    const totalPages = Math.ceil(data.length / itemsPerPage);
    const currentData = data.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

    const AntSwitch = styled(Switch)(({ theme }) => ({
        width: 28,
        height: 16,
        padding: 0,
        marginTop:12,
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

    return (
        <>
            <Header />
            <Sidebar />
            <div className="table-container">
                <Box display={"flex"} justifyContent={"space-between"}>
                    <p style={{ fontSize: "44px", justifyContent: "center", marginBottom: '20px' }}>Manage TA</p>
                </Box>
                <table>
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>TA Name</th>
                            <th>Username</th>
                            <th>Active Students</th>
                            <th>Active Batches</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {currentData.map((item, index) => (
                            <tr key={item.id}>
                                <td>{(currentPage - 1) * itemsPerPage + index + 1}</td>
                                <td>{item.taName}</td>
                                <td>{item.username}</td>
                                <td>
                                    {item.activeStudents}{" "}
                                    <CustomButton variant="outlined" color="secondary" endIcon={<CallMadeOutlinedIcon />}>
                                        View
                                    </CustomButton >
                                </td>
                                <td>
                                    {item.activeBatches}{" "}
                                    <CustomButton variant="outlined" color="secondary" endIcon={<CallMadeOutlinedIcon />}>
                                        View
                                    </CustomButton >
                                </td>
                                <td style={{display:"flex", justifyContent:"center", verticalAlign:"middle"}}>
                                    <AntSwitch
                                        checked={item.isActive}
                                        onChange={() => handleToggle(item.id)}
                                        inputProps={{ 'aria-label': 'ant design' }}
                                    />

                                    <IconButton color="error">
                                        <DeleteOutlineOutlinedIcon />
                                    </IconButton>
                                </td>
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
        </>
    );
};

export default TableMapping;