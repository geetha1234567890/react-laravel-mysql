import React from "react";
import moment from "moment";
import CustomDateField from "./CustomDateField"; 

const CustomDateOfBirth = ({ label, name, value, onChange, ...props }) => {
  const handleDateChange = (date) => {
    const today = moment().endOf('day');
    if (date && moment(date).isAfter(today)) {
      return; 
    }
    onChange(date);
  };

  return (
    <CustomDateField
      label={label}
      name={name}
      value={value}
      onChange={handleDateChange}
      {...props}
    />
  );
};

export default CustomDateOfBirth;
