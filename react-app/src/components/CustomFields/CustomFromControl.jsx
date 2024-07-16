import React from 'react';
import { FormControl, InputLabel, Select, MenuItem, Typography } from '@mui/material';

const CustomFormControl = ({
  label,
  name,
  value,
  onChange,
  errors,
  options,
}) => {
  // console.log("label", label , name , value ) 
  return (
    <FormControl variant="outlined" fullWidth>
      <InputLabel
        style={{ margin: 0 }}
        sx={{
          color: "#1A1E3D",
          "&.Mui-focused": {
            color: "#9A9DAD", // Change label color on focus
          },
        }}
      >
        {label}
      </InputLabel>
      <Select
        label={label}
        name={name}
        value={value}
        onChange={onChange}
        error={!!errors[name]}
        MenuProps={{
          PaperProps: {
            style: {
              maxHeight: 200, // Set max height to make it scrollable
            },
          },
        }}
        sx={{
          borderRadius: "50px",
          height: "60px",
          padding: "18px 2px",
          "& .MuiOutlinedInput-notchedOutline": {
            borderColor: "#D0D0EC",
          },
          "&:hover .MuiOutlinedInput-notchedOutline": {
            borderColor: "#D0D0EC",
          },
          "&.Mui-focused .MuiOutlinedInput-notchedOutline": {
            borderColor: "rgb(245, 109, 59)", // Change border color on focus
          },
        }}
      >
        {options.map((option) => (
          <MenuItem key={option.value} value={option.value}>
            {option.label}
          </MenuItem>
        ))}
      </Select>
      {errors[name] && (
        <Typography variant="body2" color="error">
          {errors[name].message}
        </Typography>
      )}
    </FormControl>
  );
};

export default CustomFormControl;
