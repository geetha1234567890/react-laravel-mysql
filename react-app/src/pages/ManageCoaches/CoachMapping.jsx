import { Box, InputBase, Button, Modal, Typography } from '@mui/material';
import { DataGrid } from "@mui/x-data-grid";
import { mockMappingDat } from '../../fakeData/mappingData';
import Header from "../../components/Header/Header";
import Sidebar from "../../components/Sidebar/Sidebar";
import { useState , useEffect } from "react";
import { OnOffSwitch } from '../../components/Switch';
import editIcon from '../../assets/editIcon.png';
import DynamicTable from '../../components/CommonComponent/DynamicTable';
import { showCAMapping } from '../../redux/features/CoachModule/coachSlice';
import { useDispatch, useSelector } from "react-redux";

const CoachMapping = () => {
  const dispatch = useDispatch();
  const [open, setOpen] = useState(false);
  const [currentRow, setCurrentRow] = useState(null);
  const [viewType, setViewType] = useState('');
  const { coachMapping, loading } = useSelector((state) => state.coachModule);
  const [caMappingData, setcaMappingData] = useState([]);
console.log("camapping" , coachMapping);
  const handleOpenModal = () => {
    setIsModalOpen(true);
  };
  useEffect(() => {
    dispatch(showCAMapping());
  }, [dispatch]);

  useEffect(() => {
    if (coachMapping && coachMapping.length > 0) {
      const transformData = coachMapping.map((item, index) => ({
        
        id: item.id,
        name: item.name,
        Username: item.username,
        Active_Students: item.Active_Students,
        Active_Batches: item.Active_Batches,
      }));

      setcaMappingData(transformData);
    }
  }, [coachMapping]);

  const headers = [
    "S.NO.",
    "COACH Name",
    "Username",
    "Active Students",
    "Active Batches",
    "Action",
  ];
  const handleCloseModal = () => {
    setIsModalOpen(false);
  };
 
const actionButtons = [
  // {
  //   type: "switch",
  // },
  {
    type: "delete",
    onClick: (id) => console.log(`Delete clicked for id ${id}`),
  },
];
  const handleOpen = (row, type) => {
    setCurrentRow(row);
    setViewType(type);
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
    setCurrentRow(null);
    setViewType('');
  };

  const handleEdit = (id) => {
    console.log(`Edit TA with ID: ${id}`);
    handleOpenModal();
  };

  const columns = [
    { field: "id", headerName: "ID" },
    {
      field: "taName", headerName: "TA Name", flex: 1, cellClassName: "name-column--cell"
    },
    { field: "username", headerName: "User Name", flex: 1, cellClassName: "name-column--cell" },
    {
      field: "activeStudents",
      headerName: "Active Students",
      flex: 1,
      cellClassName: "name-column--cell",
      renderCell: (params) => (
        <div>
          {params.value} <Button onClick={() => handleOpen(params.row, 'students')}>View</Button>
        </div>
      ),
    },
    {
      field: "activeBatches",
      headerName: "Active Batches",
      flex: 1,
      cellClassName: "name-column--cell",
      renderCell: (params) => (
        <div>
          {params.value} <Button onClick={() => handleOpen(params.row, 'batches')}>View</Button>
        </div>
      ),
    },
    {
      field: "actions",
      headerName: "Actions",
      flex: 1,
      renderCell: (params) => (
        <Box sx={{ display: 'flex', gap: '5px', marginTop: "10px" }}>
          {/* <Box sx={{ display: 'flex', alignItems: 'center' }}>
            <OnOffSwitch />
          </Box> */}
          <Button sx={{
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            color: '#F56D3B',
            backgroundColor: '#FEEBE3',
            gap: '4px',
            height: '30px',
            width: '70px',
            borderRadius: '15px',
            padding: '5px',
            '&:hover': {
              backgroundColor: 'rgba(245, 235, 227, 0.8)',
            }
          }}
            variant='text'
            onClick={() => { handleEdit(params.row.id) }}
          >
            <img src={editIcon}
              alt=""
            />
            <small>Edit</small>
          </Button>
        </Box>
      ),
    }
  ];

  return (
    <>
      <Box m="40px">
        <Header />
        <Sidebar />
        <Box display={"flex"} justifyContent={"space-between"}>
          <p style={{ fontSize: "22px", fontWeight: "700", justifyContent: "center", margin: 0 }}>Coach Mapping</p>
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
            <Button variant="contained" onClick={handleOpenModal} style={{ backgroundColor: "#F56D3B", borderRadius: "30px" }}> <i style={{ marginRight: "5px" }} className="bi bi-plus-circle"></i> Create Mapping</Button>
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
             { <DynamicTable
                        headers={headers}
                        initialData={caMappingData}
                        actionButtons={actionButtons}
                        componentName={"Coach Mapping"}
                    />
                   }
          {/* <DataGrid
            rows={mockMappingDat}
            columns={columns}
          /> */}
        </Box>
      </Box>

      <Modal
        open={open}
        onClose={handleClose}
        aria-labelledby="simple-modal-title"
        aria-describedby="simple-modal-description"
        sx={{ display: 'flex', alignItems: 'center', justifyContent: 'center' }}
      >
        <Box sx={{ backgroundColor: 'background.paper', border: '2px solid #000', boxShadow: 24, p: 4 }}>
          <Typography variant="h6" id="simple-modal-title">
            {viewType === 'students' ? 'Active Students Details' : 'Active Batches Details'}
          </Typography>
          {currentRow && (
            <Box>
              <Typography variant="body1">
                <strong>TA Name:</strong> {currentRow.taName}
              </Typography>
              <Typography variant="body1">
                <strong>Username:</strong> {currentRow.username}
              </Typography>
              {viewType === 'students' && (
                <Typography variant="body1">
                  <strong>Active Students:</strong> {currentRow.activeStudents}
                </Typography>
              )}
              {viewType === 'batches' && (
                <Typography variant="body1">
                  <strong>Active Batches:</strong> {currentRow.activeBatches}
                </Typography>
              )}
            </Box>
          )}
        </Box>
      </Modal>
    </>
  );
}

export default CoachMapping;
