import { Button, Grid } from '@mui/material';
import React from 'react'
import { useDispatch, useSelector } from 'react-redux';
import { closeReasonForLeave } from '../../redux/features/taModule/taAvialability';
import CustomTextField from '../CustomFields/CustomTextField';
import ReusableDialog from '../CustomFields/ReusableDialog';

const CustomButton = ({ onClick, children, color = '#FFFFFF', backgroundColor = '#4E18A5', borderColor = '#FFFFFF', sx, ...props }) => {
    return (
        <Button
            variant="contained"
            onClick={onClick}
            sx={{
                backgroundColor: backgroundColor,
                color: color,
                fontWeight: '700',
                fontSize: '16px',
                borderRadius: '50px',
                padding: "10px 20px",
                border: `2px solid ${borderColor}`,
                '&:hover': {
                    backgroundColor: color,
                    color: backgroundColor,
                    borderColor: color,
                },
                ...sx
            }}
            {...props}
        >
            {children}
        </Button>
    );
};

const ReasonForLeave = () => {

    const dispatch = useDispatch()
    const { reasonForLeaveOpen } = useSelector((state) => state.taAvialability)

    const handleSubmit = () => {
        dispatch(closeReasonForLeave())
    };

    const content = (
            <Grid container spacing={2}>
                <Grid item xs={12}>
                    <CustomTextField
                        label="Reason for Deletion"
                        fullWidth
                        placeholder="Enter reason for deletion"
                        variant="outlined"
                        multiline
                        rows={4}
                    />
                </Grid>
            </Grid>
    );

    const actions = (
            <CustomButton
                onClick={handleSubmit}
                backgroundColor= '#F56D3B'
                borderColor= '#F56D3B'
                color= '#FFFFFF'
            >
                Submit
            </CustomButton>
    );

    return (
        <ReusableDialog
            open={reasonForLeaveOpen}
            handleClose={() => dispatch(closeReasonForLeave())}
            title="Reason For Leave"
            content={content}
            actions={actions}
        />
    );
}

export default ReasonForLeave