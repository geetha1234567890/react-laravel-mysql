import React from "react";
import ReusableDialog from "../CustomFields/ReusableDialog";
import { Box, Button, DialogContent, Typography } from "@mui/material";
import DynamicTable from "../CommonComponent/DynamicTable";
import { useDispatch, useSelector } from "react-redux";
import {
  closeScheduledSession,
  openCancelSession,
  openRescheduleSession,
} from "../../redux/features/taModule/taAvialability";
import PopUpTable from "../CommonComponent/PopUpTable";

const CustomButton = ({
  onClick,
  children,
  color = "#FFFFFF",
  backgroundColor = "#4E18A5",
  borderColor = "#FFFFFF",
  sx,
  ...props
}) => {
  return (
    <Button
      variant="contained"
      onClick={onClick}
      sx={{
        backgroundColor: backgroundColor,
        color: color,
        fontWeight: "700",
        fontSize: "16px",
        borderRadius: "50px",
        padding: "10px 20px",
        border: `2px solid ${borderColor}`,
        "&:hover": {
          backgroundColor: color,
          color: backgroundColor,
          borderColor: color,
        },
        ...sx,
      }}
      {...props}
    >
      {children}
    </Button>
  );
};

const ScheduledSessions = () => {
  const dispatch = useDispatch();
  const { scheduledSessionOpen, scheduledSessionData } = useSelector(
    (state) => state.taAvialability
  );

  const headers = [
    "S. No.",
    "Session Name",
    "Date",
    "Time",
    "Students",
    "Actions",
  ];

  const formattedData = scheduledSessionData.map((session, index) => ({
    "S. No.": index + 1,
    "Session Name": session.meeting_name,
    Date: session.date.split(" ")[0],
    Time: `${session.start_time} - ${session.end_time}`,
    Students: session.Students.length,
    StudentList: session.Students,
  }));

  const handleViewClick = (students) => {
    // Open a popup to view the students
    console.log("View clicked!", students);
  };

  const handleRescheduleClick = (session) => {
    dispatch(closeScheduledSession());
    dispatch(openRescheduleSession());
    console.log("Reschedule clicked!", session);
  };

  const handleCancelClick = (session) => {
    dispatch(closeScheduledSession());
    dispatch(openCancelSession(session));
    console.log("Cancel clicked!", session);
  };

  const handleSubmit = () => {
    console.log("*** ScheduledSessions");
  };

  const content = (
    formattedData.length === 0 ? (
      <DialogContent style={{ justifyContent: "center", display: "flex" }}>
        <Typography>
          No scheduled sessions.
        </Typography>
      </DialogContent>
    ) : (
      <PopUpTable
        headers={headers}
        initialData={formattedData}
        onViewClick={handleViewClick}
        onRescheduleClick={handleRescheduleClick}
        onCancelClick={handleCancelClick}
      />
    )
  );

  const actions = (
    <Box>
      <CustomButton
        onClick={handleSubmit}
        backgroundColor="#F56D3B"
        borderColor="#F56D3B"
        color="#FFFFFF"
      >
        Submit
      </CustomButton>
    </Box>
  );

  return (
    <ReusableDialog
      open={scheduledSessionOpen}
      handleClose={() => dispatch(closeScheduledSession())}
      title="Scheduled Sessions"
      content={content}
      actions={actions}
    />
  );
};

export default ScheduledSessions;


