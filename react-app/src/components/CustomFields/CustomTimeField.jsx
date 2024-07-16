import React from "react";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import { LocalizationProvider, TimePicker } from "@mui/x-date-pickers"; // Import TimePicker instead of DateTimePicker
import moment from "moment";

const CustomTimeField = ({
  label,
  name,
  value,
  onChange,
  sx,
  ...props
}) => {
  const momentValue = value ? moment(value, "YYYY-MM-DDTHH:mm:ss") : null; // Adjust parsing format based on input

  const handleTimeChange = (date) => {
    onChange(date.format("HH:mm:ss")); // Update onChange to only pass time
  };

  return (
    <LocalizationProvider dateAdapter={AdapterDayjs}>
      <TimePicker
        label={label}
        name={name}
        value={momentValue}
        onChange={handleTimeChange}
        inputFormat="HH:mm:ss" // Specify the desired time format
        InputLabelProps={{
          shrink: true,
        }}
        {...props}
        sx={{
          "& .MuiOutlinedInput-root": {
            borderRadius: "50px",
            "& fieldset": {
              borderColor: "#D0D0EC",
            },
            "&:hover fieldset": {
              borderColor: "#D0D0EC",
            },
            "&.Mui-focused fieldset": {
              borderColor: "rgb(245, 109, 59)",
            },
          },
          "& .MuiInputLabel-root": {
            margin: 0,
            color: '#1A1E3D',
            '&.Mui-focused': {
                color: '#1A1E3D',
            },
          },
          ...sx,
        }}
      />
    </LocalizationProvider>
  );
};

export default CustomTimeField;

