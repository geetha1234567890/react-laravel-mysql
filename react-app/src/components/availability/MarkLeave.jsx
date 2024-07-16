import React, { useState } from "react";
import {
  DialogContent,
  Grid,
  TextField,
  Button,
  IconButton,
} from "@mui/material";
import { LocalizationProvider, DatePicker } from "@mui/x-date-pickers";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import CloseIcon from "@mui/icons-material/Close";
import ReusableDialog from "../CustomFields/ReusableDialog";
import CustomDateField from "../CustomFields/CustomDateField";
import Slots from "./Slots";
import {
  openScheduledSlots,
  closeScheduledSlots,
  closeMarkLeave,
  getSlots,
} from "../../redux/features/taModule/taAvialability";
import { useDispatch, useSelector } from "react-redux";
import moment from "moment";
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

const MarkLeave = () => {
  const dispatch = useDispatch();
  const { markLeaveOpen } = useSelector((state) => state.taAvialability);
  const [fromDate, setFromDate] = useState(null);
  const [toDate, setToDate] = useState(null);

  const handleSubmit = () => {
    const formattedFromDate = moment(fromDate).format("YYYY-MM-DD");
    const formattedToDate = moment(toDate).format("YYYY-MM-DD");

    const leaveData = {
      admin_user_id: 2, // Replace with the actual admin user ID
      start_date: formattedFromDate,
      end_date: formattedToDate,
    };
    dispatch(getSlots(leaveData))
      .unwrap()
      .then(() => {
        dispatch(closeMarkLeave());
        dispatch(openScheduledSlots());
      })
      .catch((error) => {
        console.error("Failed to fetch scheduled slots:", error);
      });
  };

  const content = (
    <Grid
      container
      sx={{
        pt: 3,
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        textAlign: "center", // Add this line if needed
      }}
    >
      <Grid item xs={12} sm={6}>
        <CustomDateField
          label="From Date"
          value={fromDate}
          onChange={setFromDate}
        />
      </Grid>
      <Grid item xs={12} sm={6}>
        <CustomDateField label="To Date" value={toDate} onChange={setToDate} />
      </Grid>
    </Grid>
  );

  const actions = (
    <CustomButton
      onClick={handleSubmit}
      backgroundColor="#F56D3B"
      borderColor="#F56D3B"
      color="#FFFFFF"
    >
      Submit
    </CustomButton>
  );

  return (
    <>
      <ReusableDialog
        open={markLeaveOpen}
        handleClose={() => dispatch(closeMarkLeave())}
        title="Mark Leave"
        content={content}
        actions={actions}
      />
    </>
  );
};

export default MarkLeave;
