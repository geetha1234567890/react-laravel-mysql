import React, { useState } from "react";
import Header from "../../../components/Header/Header";
import Sidebar from "../../../components/Sidebar/Sidebar";
import { Box } from "@mui/material";
import AddModule from "./TemplateModulePopup/AddModule";
import { useDispatch, useSelector } from "react-redux";
import { openEditModulePopup, openTemplateActivityPopup, openTemplateModulePopup } from "../../../redux/features/CoachModule/CoachTemplateSlice";
import TemplateModuleTable from "./TemplateModuleTable/TemplateModuleTable";
import "./TemplateName.css";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPenToSquare } from "@fortawesome/free-solid-svg-icons";
import AddActivity from "./TemplateModulePopup/AddActivity";
import EditModule from "./TemplateModulePopup/EditModule";

const TemplateName = () => {
  const { openModulePopUp, openActivityPopUp } = useSelector((state) => state.coachTemplate);
  const [isActive, setIsActive] = useState(true);
  const dispatch = useDispatch();
  const handleModule = () => {
    dispatch(openTemplateModulePopup());
  };

  const handleActivity = () => {
    dispatch(openTemplateActivityPopup());
  };

  const handleEditModule = () => {
    dispatch(openEditModulePopup());
  };

  const headers = [
    "S. No.",
    "Activity Name",
    "Due Date",
    "Activity",
    "Points",
    "Prerequisites",
    "After Due Date",
    "Actions",
  ];

  const dummyData = [
    {
      id: 1,
      "Activity Name": "Introduction to React",
      "Due Date": "2024-07-15",
      Activity: "Video Name",
      Points: 10,
      Prerequisites: "Activity 1, Activity 2",
      "After Due Date": "Late Submission",
    },
    {
      id: 2,
      "Activity Name": "React Components",
      "Due Date": "2024-07-20",
      Activity: "Link Activity",
      Points: 15,
      Prerequisites: "Prerequisites",
      "After Due Date": "Late Submission",
    },
    {
      id: 3,
      "Activity Name": "State and Props",
      "Due Date": "2024-07-25",
      Activity: "Video Name",
      Points: 20,
      Prerequisites: "Prerequisites",
      "After Due Date": "No Penalty",
    },
    {
      id: 4,
      "Activity Name": "React Lifecycle",
      "Due Date": "2024-07-30",
      Activity: "Link Activity",
      Points: 25,
      Prerequisites: "Prerequisites",
      "After Due Date": "No Penalty",
    },
    {
      id: 5,
      "Activity Name": "Handling Events",
      "Due Date": "2024-08-05",
      Activity: "Video Name",
      Points: 30,
      Prerequisites: "Activity 1, Activity 2",
      "After Due Date": "Late Submission",
    },
  ];
  // const dummyData = [];

  const actionButtons = [
    {
      type: "switch",
    },
    {
      type: "edit",
      onClick: (id) => {
        console.log("CLICKED : ", id);
      },
    },
  ]; // Define your action buttons if any

  return (
    <>
      <Header />
      <Sidebar />
      <Box
        display={"flex"}
        justifyContent={"space-between"}
        marginTop={3}
        alignItems={"center"}
      >
        <p style={{ fontSize: "44px", justifyContent: "center" }}>
          Template Name
        </p>
        <div className="inputBtnContainer">
          <button className="buttonContainer" onClick={handleModule}>
            <i className="bi bi-plus-circle"></i>
            <span>Add Module</span>
          </button>
        </div>
      </Box>
      {!dummyData || dummyData.length === 0 ? (
        <div>{/* <p>No Data Available</p> */}</div>
      ) : (
        <>
          <Box
            display={"flex"}
            justifyContent={"space-between"}
            marginTop={3}
            alignItems={"center"}
          >
            <p style={{ fontSize: "24px", justifyContent: "center" }}>
              Template Name{" "}
              <span
                style={{
                  borderRadius: "50px",
                  backgroundColor: isActive ? "#14D249" : "red",
                  color: "white",
                  padding: "3px 10px",
                  marginLeft: "10px",
                  fontSize:"12px"
                }}
              >
                {isActive ? "Active" : "Inactive"}
              </span>
            </p>
            <div className="inputBtnContainer">
              <button className="buttonTemplateContainer" onClick={handleActivity}>
                <i className="bi bi-plus-circle"></i>
                <span>Add Activity</span>
              </button>

              <button className="buttonTemplateContainer" onClick={handleEditModule}>
                <FontAwesomeIcon icon={faPenToSquare} className="bi" />
                <span>Edit Module</span>
              </button>
            </div>
          </Box>

          <TemplateModuleTable
            headers={headers}
            initialData={Array.isArray(dummyData) ? dummyData : []}
            actionButtons={actionButtons}
            componentName={"TemplateName"}
          />
        </>
      )}

      {openModulePopUp && <AddModule />}
      {openActivityPopUp && <AddActivity />}
      {openEditModulePopup && <EditModule />}
    </>
  );
};

export default TemplateName;
