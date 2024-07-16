import { Box, InputBase, Button, Modal, TextField, IconButton, Switch, Select, MenuItem, FormControl, InputLabel, Snackbar, Alert } from '@mui/material';
import { DataGrid } from "@mui/x-data-grid";
import { mockManageAvailable } from '../../fakeData/manageCoachData';
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import { useEffect , useState } from "react";
import { OnOffSwitch } from '../../components/Switch';
import AddEditCoach from '../../components/adminModule/coaches/manageCoaches/AddEditCoach';
import editIcon from '../../assets/editIcon.png';
import { useNavigate } from 'react-router-dom'; 
import DynamicTable from '../../components/CommonComponent/DynamicTable';
import CreateCoachPage from './CreateCoachPage';
import { useDispatch, useSelector } from "react-redux";
import {
    getCoach,
    openCreateCoach,
    closeCreateCoach,
    openEditCoach,
    closeEditCoach,
    setSelectedCoach,
    openSuccessPopup,
    accessCoachName,
    closeSuccessPopup,
    openAssignStudents,
    closeAssignStudents,
    openAssignBatches,
    closeAssignBatches,
} from '../../redux/features/CoachModule/coachSlice';

const ManageCoaches = () => {
    const dispatch = useDispatch();
    const navigate = useNavigate();

    // State variables
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedCoachData, setSelectedCoachData] = useState(null);
    const [coachesData, setCoachesData] = useState([]);
    const [isAddEditCoachOpen, setIsAddEditCoachOpen] = useState(false);
    const [formValues, setFormValues] = useState({});
    const [editData, setEditData] = useState();
    const [openSnackbar, setOpenSnackbar] = useState(false);
    const { coaches , loading, error, createCoachOpen, editCoachOpen } = useSelector((state) => state.coachModule);

console.log("coachess " , coaches);
    // Fetch coach data on component mount
    useEffect(() => {
        dispatch(closeCreateCoach());
        dispatch(closeEditCoach());
        dispatch(getCoach());
    }, [dispatch]);

    // Action buttons for the DynamicTable
    const actionButtons = [
        {
          type: "switch",
        },
        {
          type: "edit",
          onClick: (id) => {
            handleEditCoaches(id);
          },
        },
      ];
      useEffect(() => {
        if (coaches.length > 0) {
          const transformData = coaches.map((item) => ({
            id: item.id,
            "TA Name": item.name,
            Username: item.username,
            Location: item.location,
            'Time Zone': item.time_zone,
            is_active: item.is_active,
          }));
    
          setCoachesData(transformData);
        }
      }, [coaches]);
    // Handlers
    const handleAddTa = () => {
        dispatch(openCreateCoach());
      };
    
    const handleEditCoaches = (id) => {
        console.log("coachesssss", coaches);
        console.log("id", id);
        const coachData = coaches.find((ta) => ta.id === id);
        
        console.log("coachData" , coachData);
        setSelectedCoachData(coachData);
        setEditData(coachData);
        dispatch(openEditCoach());
      };
    const handleAddCoach = () => {
        navigate('/createcoach');
    };
    console.log("EditData" , editCoachOpen);
    const handleEdit = (id) => {
        const coachData = tasData.find(ta => ta.id === id);
        setSelectedCoachData(coachData);
        setIsAddEditCoachOpen(true);
    };

    const handleCloseAddEditCoach = () => {
        setIsAddEditCoachOpen(false);
    };

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
    };

    const headers = [
        "S. No.",
        "COACH Name",
        "Username",
        "Location",
        "Time Zone",
        "Action",
    ];

    const handleSubmitForm = (event) => {
        event.preventDefault();
        console.log(formValues);
        setOpenSnackbar(true);  // Show the success popup
        handleCloseModal();
    };

    const handleInputChange = (event) => {
        const { name, value } = event.target;
        setFormValues({
            ...formValues,
            [name]: value,
        });
    };

    const handleToggle = (id) => {
        console.log(`Toggle TA with ID: ${id}`);
    };

    const handleCloseSnackbar = () => {
        setOpenSnackbar(false);
    };
 // Filter tasData based on the search query


    return (
        <>
        {!createCoachOpen && !editCoachOpen && (
            <Box m="40px">
                <Header />
                <Sidebar />
                <Box display={"flex"} justifyContent={"space-between"}>
                    <p style={{ fontSize: "22px", fontWeight: "700", justifyContent: "center", margin: 0 }}>Manage Coach</p>
                    <Box display={"flex"}>
                        <Box
                            display={"flex"}
                            backgroundColor="#FFF"
                            borderRadius={"30px"}
                            width={"30vh"}
                            marginRight={"10px"}
                        >
                            <InputBase sx={{ ml: 2, flex: 1 }} placeholder="Search here ..." />
                        </Box>
                        <Button variant="contained" onClick={handleAddCoach} style={{ backgroundColor: "#F56D3B", borderRadius: "30px" }}>
                            <i style={{ marginRight: "5px" }} className="bi bi-plus-circle"></i> <span>Create Coach</span>
                        </Button>
                    </Box>
                </Box>
                <Box m="20px 0 0 0" height={"70vh"} sx={{
                    "& .MuiDataGrid-root": {
                        border: "none",
                    },
                    "& .MuiDataGrid-cell": {
                        borderBottom: "none"
                    },
                    "& .name-column--cell": {
                        color: "#5F6383"
                    },
                    "& .MuiDataGrid-columnHeader": {
                        backgroundColor: "#FFF",
                        borderBottom: "none",
                    },
                    "& .MuiDataGrid-columnHeaderTitle": {
                        color: "#1A1E3D",
                        fontWeight: "600",
                        fontSize: 16
                    },
                    "& .MuiDatGrid-virtualScroller": {
                        backgroundColor: "#FFF"
                    },
                    "& .MuiDataGrid-footerContainer": {
                        borderTop: "none",
                        backgroundColor: "#FFF"
                    },
                    "& .MuiDataGrid-virtualScrollerContent": {
                        backgroundColor: "#FFF"
                    }
                }}>
                    <DynamicTable
                        headers={headers}
                        initialData={coachesData}
                        actionButtons={actionButtons}
                        componentName={"MANAGECOACH"}
                    />
             
                </Box>
            </Box>
        )}
           {createCoachOpen && <AddEditCoach/>}
                    {editCoachOpen  && <AddEditCoach data={editData}/> }
            {/* Snackbar for success message */}
            <Snackbar open={openSnackbar} autoHideDuration={6000} onClose={handleCloseSnackbar}>
                <Alert onClose={handleCloseSnackbar} severity="success" sx={{ width: '100%' }}>
                    Form submitted successfully!
                </Alert>
         </Snackbar>
    
        </>
    );
}

export default ManageCoaches;
