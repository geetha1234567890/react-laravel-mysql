import React, { useEffect, useState } from "react";
import { Button } from "@mui/material";
import ReusableDialog from "../CustomFields/ReusableDialog";
import DynamicTable from "../CommonComponent/DynamicTable";
import { useDispatch, useSelector } from "react-redux";
import {
  closeScheduledSlots,
  openScheduledSession,
  getScheduleSession,
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

const Slots = () => {
  const dispatch = useDispatch();
  const taAvialability = useSelector((state) => state.taAvialability);
  const {
    scheduledSlotsData = [],
    scheduledSlotsOpen = false,
    error,
  } = taAvialability || {};
  const [selectedSlots, setSelectedSlots] = useState([]);
  const [data, setData] = useState([]);

  useEffect(() => {
    console.log("HELLO  : ", scheduledSlotsData)
    const formattedData = scheduledSlotsData.map((slot) => ({
      "S. No.": slot.id,
      Date: slot.slot_date,
      "Slot Time": `${slot.from_time} - ${slot.to_time}`, // Adjust according to your data structure
      Select: selectedSlots.includes(slot.id),
    }));
    setData(formattedData);
  }, [scheduledSlotsData, selectedSlots]);

  const handleSelect = (id) => {
    setSelectedSlots((prev) =>
      prev.includes(id) ? prev.filter((slotId) => slotId !== id) : [...prev, id]
    );
  };

  const handleSubmit = () => {
    const formattedSelectedSlots = selectedSlots.map((slotId) => {
      const slot = scheduledSlotsData.find((s) => s.id === slotId);
      return {
        slot_id: slot.id,
        date: slot.slot_date,
        start_time: slot.from_time,
        end_time: slot.to_time,
      };
    });

    const requestData = {
      admin_user_id: 2,
      data: formattedSelectedSlots,
    };

    console.log("Submitting selected slots:", requestData);

    // Dispatch the thunk action
    dispatch(getScheduleSession(requestData))
      .then((response) => {
        console.log("API response:", response);
        // Handle successful response
        dispatch(closeScheduledSlots());
        dispatch(openScheduledSession());
      })
      .catch((error) => {
        console.error("API error:", error);
        // Handle error response
      });
  };

  const headers = ["S. No.", "Date", "Slot Time", "Select"];

  const table = (
    <PopUpTable
      headers={headers}
      initialData={data}
      onRowClick={handleSelect}
      selectedBox={selectedSlots}
    />
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
    <ReusableDialog
      open={scheduledSlotsOpen}
      handleClose={() => dispatch(closeScheduledSlots())}
      title="Slots"
      content={table}
      actions={actions}
    />
  );
};

export default Slots;
