import React, { useState } from "react";
import ReusableDialog from "../../../../components/CustomFields/ReusableDialog";
import { Button, Grid } from "@mui/material";
import CustomTextField from "../../../../components/CustomFields/CustomTextField";
import { closeTemplateActivityPopup } from "../../../../redux/features/CoachModule/CoachTemplateSlice";
import { useDispatch, useSelector } from "react-redux";
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
const AddActivity = () => {
  const dispatch = useDispatch();
  const [activityName, setActivityName] = useState("");
  const [activityType, setActivityType] = useState("");
  const { openActivityPopUp } = useSelector((state) => state.coachTemplate);
  const content = (
    <Grid
      container
      sx={{
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        textAlign: "center",
        width: "100%", // Ensure the container takes the full width
      }}
    >
      <Grid
        item
        xs={12}
        sm={6}
        md={6}
        style={{ margin: "10px 0px", width: "80%" }}
      >
        <CustomTextField
          label="Activity Name"
          variant="outlined"
          value={activityName}
          onChange={(e) => setActivityName(e.target.value)}
          placeholder="Enter Activity Name"
          name="activityName"
          fullWidth
        />
      </Grid>
      <Grid
        item
        xs={12}
        sm={6}
        md={6}
        style={{ margin: "10px 0px", width: "80%" }}
      >
        <CustomTextField
          label="Activity Type"
          variant="outlined"
          value={activityType}
          onChange={(e) => setActivityType(e.target.value)}
          placeholder="Enter Activity Type"
          name="activityType"
          fullWidth
        />
      </Grid>
    </Grid>
  );

  const actions = (
    <CustomButton
      //   onClick={handleSubmit}
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
        open={openActivityPopUp}
        handleClose={() => dispatch(closeTemplateActivityPopup())}
        title="Add Activity"
        content={content}
        actions={actions}
      />
    </>
  );
};

export default AddActivity;
