import React from 'react';
import { TextField } from '@mui/material';

const CustomTextField = ({ label, name, placeholder, register = () => {}, validation = {}, errors = {}, type = "text", multiline = false, rows = 1, ...props }) => {
    const inputPropsStyle = multiline ? { borderRadius: '25px', padding: '25px 30px 18px 30px' } : { height: '60px', borderRadius: '50px', padding: '18px 2px' };

    return (
        <TextField
            label={label}
            name={name}
            type={type}
            placeholder={placeholder}
            fullWidth
            multiline={multiline}
            rows={rows}
            {...register(name, validation)}
            error={!!errors[name]}
            helperText={errors[name]?.message}
            variant="outlined"
            InputProps={{ style: inputPropsStyle }}
            InputLabelProps={{ style: { margin: 0 } }}
            sx={{
                '& .MuiOutlinedInput-root': {
                    '& fieldset': {
                        borderColor: '#D0D0EC',
                    },
                    '&:hover fieldset': {
                        borderColor: '#D0D0EC',
                    },
                    '&.Mui-focused fieldset': {
                        borderColor: 'rgb(245, 109, 59)', // Change border color on focus
                    },
                    '&.Mui-focused.Mui-autocomplete-input': {
                        backgroundColor: 'transparent', // Override background color for autofill state
                    },
                    '&.Mui-focused.Mui-filled': {
                        backgroundColor: 'transparent', // Override background color for autofill state
                    }
                },
                '& .MuiInputLabel-root': {
                    color: '#1A1E3D',
                    // fontSize:"17px" ,
                    '&.Mui-focused': {
                        color: '#1A1E3D',
                        // Change label color on focus
                    },
                },
            }}
            {...props} // Spread any additional props
        />
    );
};

export default CustomTextField;
