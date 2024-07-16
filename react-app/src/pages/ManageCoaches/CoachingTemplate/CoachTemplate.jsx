import React from "react";
import Header from "../../../components/Header/Header";
import Sidebar from "../../../components/Sidebar/Sidebar";
import { Box } from "@mui/material";
import DynamicTable from "../../../components/CommonComponent/DynamicTable";
import { openCreateTemplateCoach } from "../../../redux/features/CoachModule/CoachTemplateSlice";
import { useNavigate } from "react-router-dom";

const CoachTemplate = () => {
  const navigation = useNavigate();
  const headers = [
    "S. No.",
    "Template Name",
    "Duration",
    "Activities",
    "Assigned To",
    "Action"
  ];

  const dummyData = [
    {
      id: 1,
      "Template Name": "Template 1",
      Duration: "30 mins",
      Activities: "Activity A, Activity B",
      "Assigned To": "John Doe",
    },
    {
      id: 2,
      "Template Name": "Template 2",
      Duration: "45 mins",
      Activities: "Activity C, Activity D",
      "Assigned To": "Jane Smith",
    },
    {
      id: 3,
      "Template Name": "Template 3",
      Duration: "60 mins",
      Activities: "Activity E, Activity F",
      "Assigned To": "Michael Brown",
    }
  ];

  const actionButtons = [
    {
      type: "switch",
    },
    {
      type: "edit",
      onClick: (id) => {
        console.log("CLICKED : ", id)
      },
    },
  ];


  const handleAddTa = () => {
    // dispatch(openCreateTemplateCoach());
    navigation("/create-template")
  };

  return (
    <>
      <Header />
      <Sidebar />
      <>
        <Box
          display={"flex"}
          justifyContent={"space-between"}
          marginTop={3}
          alignItems={"center"}
        >
          <p style={{ fontSize: "44px", justifyContent: "center" }}>
            Coaching Template
          </p>
          <div className="inputBtnContainer">
            <button className="buttonContainer" onClick={handleAddTa}>
              <i className="bi bi-plus-circle"></i>
              <span>Create New Template</span>
            </button>
          </div>
        </Box>
        {!dummyData || dummyData.length === 0 ? (
          <div>
            <p>No Data Available</p>
          </div>
        ) : (
          <DynamicTable
            headers={headers}
            initialData={dummyData}
            actionButtons={actionButtons}
            componentName={"COACHTEMPLATE"}
          />
        )}
      </>
    </>
  );
};

export default CoachTemplate;
