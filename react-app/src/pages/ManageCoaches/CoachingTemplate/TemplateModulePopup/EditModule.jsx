import React, { useState } from "react";
import ReusableDialog from "../../../../components/CustomFields/ReusableDialog";
import {
  Button,
  FormControl,
  Grid,
  InputLabel,
  MenuItem,
  Select,
} from "@mui/material";
import CustomTextField from "../../../../components/CustomFields/CustomTextField";
import { closeEditModulePopup } from "../../../../redux/features/CoachModule/CoachTemplateSlice";
import { useDispatch, useSelector } from "react-redux";
import { Controller, useForm } from "react-hook-form";
import CustomFormControl from "../../../../components/CustomFields/CustomFromControl";
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
const EditModule = () => {
  const dispatch = useDispatch();
  const [moduleName, setModuleName] = useState("");
  const [status, setStatus] = useState("Active"); // State for status
  const { handleSubmit, control, formState: { errors } } = useForm();
  const { openEditModulePopUp } = useSelector((state) => state.coachTemplate);

  const statusOptions = [
    { value: "Active", label: "Active" },
    { value: "Inactive", label: "Inactive" },
  ];

  const handleStatusChange = (event) => {
    setStatus(event.target.value); // Update status state on change
  };

  const onSubmit = (data) => {
    console.log(data); // Example: Log form data
  };

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
          label="Module Name"
          variant="outlined"
          value={moduleName}
          onChange={(e) => setModuleName(e.target.value)}
          placeholder="Enter Module Name"
          name="moduleName"
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
        <Controller
          name="status"
          control={control}
          defaultValue="Active" // Set default value
          render={({ field }) => (
            <CustomFormControl
              label="Status"
              name="status"
              value={field.value}
              onChange={(e) => {
                field.onChange(e);
                handleStatusChange(e);
              }}
              errors={errors}
              options={statusOptions}
            />
          )}
        />
      </Grid>
    </Grid>
  );

  const actions = (
    <CustomButton
      onClick={handleSubmit(onSubmit)}
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
        open={openEditModulePopUp}
        handleClose={() => dispatch(closeEditModulePopup())}
        title="Edit Module"
        content={content}
        actions={actions}
      />
    </>
  );
};

export default EditModule;
