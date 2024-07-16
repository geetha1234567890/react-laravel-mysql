import React, { useState } from "react";
import { Box, Grid, TextField, Button, MenuItem } from "@mui/material";
import CustomTextField from "../../../../components/CustomFields/CustomTextField";
import { styled } from "@mui/material/styles";
import { useNavigate } from "react-router-dom";

const durations = [
  { value: "30 mins", label: "30 mins" },
  { value: "45 mins", label: "45 mins" },
  { value: "60 mins", label: "60 mins" },
];

const CustomButton = styled(Button)(({ theme, active }) => ({
  borderRadius: "50px",
  border: "1px solid #F56D3B",
  color: active ? "#fff" : "#F56D3B",
  backgroundColor: active ? "#F56D3B" : "#FFF",
  padding: "8px 16px", // Add padding for horizontal and vertical spacing
  margin: "0 8px",
  "&:hover": {
    backgroundColor: "#F56D3B",
    color: "#fff",
    borderColor: "#F56D3B",
  },
}));

const CoachTemplateForm = () => {
  const [templateName, setTemplateName] = useState("");
  const [duration, setDuration] = useState("");
  const navigation = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    // Handle form submission
    console.log(`Template Name: ${templateName}, Duration: ${duration}`);
    navigation("/template-name")
  };

  return (
    <Box
      component="form"
      onSubmit={handleSubmit}
      sx={{
        backgroundColor: "#FFFFFF",
        borderRadius: "10px",
        padding: "20px",
        // maxWidth: "800px",
        margin: "0 auto",
        marginTop: "50px",
      }}
    >
      <Grid container spacing={3} sx={{ maxWidth: "800px" }}>
        <Grid item xs={12} sm={6}>
          <CustomTextField
            // fullWidth
            label="Template Name"
            variant="outlined"
            value={templateName}
            onChange={(e) => setTemplateName(e.target.value)}
            placeholder="Enter Template Name"
            name="templateName"
          />
        </Grid>
        <Grid item xs={12} sm={6}>
          <CustomTextField
            // fullWidth
            select
            label="Duration"
            value={duration}
            onChange={(e) => setDuration(e.target.value)}
            variant="outlined"
            name="duration"
          >
            {durations.map((option) => (
              <MenuItem key={option.value} value={option.value}>
                {option.label}
              </MenuItem>
            ))}
          </CustomTextField>
        </Grid>
        <Grid item xs={12}>
          <Button
            type="submit"
            variant="contained"
            sx={{
              backgroundColor: "#F56D38",
              color: "#FFFFFF",
              borderRadius: "50px",
              padding: "10px 20px",
              border: "2px solid #F56D38",
              "&:hover": {
                backgroundColor: "#FFFFFF",
                color: "#F56D38",
                borderColor: "#F56D38",
              },
            }}
          >
            Submit
          </Button>
        </Grid>
      </Grid>
    </Box>
  );
};

export default CoachTemplateForm;
