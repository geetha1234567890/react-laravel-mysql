import { Box, Button, Dialog, DialogActions, DialogTitle, IconButton, Typography } from '@mui/material'
import React from 'react'
import CloseIcon from '@mui/icons-material/Close';
import { useDispatch, useSelector } from 'react-redux';
import { closeCreateTa, closeEditTa, closeSuccessPopup, openAssignBatches, openAssignStudents, openSuccessPopup } from '../../redux/features/taModule/taSlice';
import ReusableDialog from '../CustomFields/ReusableDialog';
import { Navigate, useNavigate } from 'react-router-dom';

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

const SubmitPopup = ({componentname}) => {
    const dispatch = useDispatch()
    const navigate = useNavigate()
    if (componentname) {
        // console.log("componentname", componentname);
    }
    
    let stateModuleKey;
    let nameKey;
    
    switch (componentname) {
        case "ADDITCOACH":
            stateModuleKey = "coachModule";
            nameKey = "coach_name";
            break;
        case "ADDEDITTA":
            stateModuleKey = "taModule";
            nameKey = "ta_name";
            break;
        default:
            stateModuleKey = null;
            nameKey = null;
            break;
    }
    
    const { successPopup, error, loading, ta_name, coach_name} = useSelector((state) => stateModuleKey ? state[stateModuleKey] : {}) || {};
    
    const displayName = nameKey === "ta_name" ? ta_name : coach_name;
    
    const handleAssignBatches = () => {
        dispatch(closeSuccessPopup())
        dispatch(openAssignBatches())
    }

    const handleAssignStudents = () => {
        dispatch(closeSuccessPopup())
        dispatch(openAssignStudents());
    }

    const handleCloseButton = () =>{
        dispatch(closeSuccessPopup())
        dispatch(closeCreateTa())
        dispatch(closeEditTa())
        navigate("/ta-mapping")
    } 

    const actions = (
        <>  
            <CustomButton
                onClick={handleAssignStudents}
                backgroundColor='#F56D3B'
                color='white'
                borderColor='#F56D3B'
            >
                Assign Students
            </CustomButton>
            <CustomButton
                onClick={handleAssignBatches}
                backgroundColor='white'
                color='#F56D3B'
                borderColor='#F56D3B'
            >
                Assign Batches
            </CustomButton>
        </>
    );

    return (
        <ReusableDialog
            open={successPopup}
            handleClose={() => handleCloseButton()}
            title={`${displayName} successfully created.`}
            actions={actions}
        />
    )
}

export default SubmitPopup