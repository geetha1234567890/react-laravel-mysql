import React from 'react'
import ReusableDialog from '../CustomFields/ReusableDialog'
import { Box, Button, DialogContent, DialogTitle, Typography } from '@mui/material'
import { useDispatch, useSelector } from 'react-redux'
import { closeCancelSession, closeReasonForLeave, openReasonForLeave, openScheduledSession } from '../../redux/features/taModule/taAvialability'

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

const CancelSchedule = () => {
    const dispatch = useDispatch()
    const { cancelSessionOpen ,schduldeCancelData } = useSelector((state) => state.taAvialability)
    console.log("schduldeCancelData : ",schduldeCancelData)
    const actions = (
        <Box>
        <CustomButton
            onClick={() => {
                dispatch(closeCancelSession())
                // dispatch(openScheduledSession())
                dispatch(openReasonForLeave()) 
            }}
            backgroundColor="#FFFFFF"
            borderColor="#F56D38"
            color="#F56D38"
            sx={{ mr: 2 }}
        >
            Yes
        </CustomButton>
        <CustomButton
            onClick={() => {
                dispatch(closeCancelSession())
                dispatch(openScheduledSession())
            }}
            backgroundColor="#F56D38"
            borderColor="#F56D38"
            color="#FFFFFF"
        >
            No
        </CustomButton>
    </Box>
    )

    const content = (
        <>
            <DialogTitle>
                {/* `'${Batch_Info} - ${Week_Info}'` */}
               {schduldeCancelData["Session Name"]}
            </DialogTitle>
            <DialogContent style={{display:'flex', justifyContent:"center"}}>
                <Typography>
                    {/* `scheduled for ${date} from ${from_time} to ${to_fime}` */}
                    Scheduled for Date from {schduldeCancelData.Time} ?
                </Typography>
            </DialogContent>
        </>
    )

    return (
        <ReusableDialog
            open={cancelSessionOpen}
            handleClose={()=> dispatch(closeCancelSession())}
            title="Are you sure that you want to cancel the session"
            content={content}
            actions={actions}
        />
    )
}

export default CancelSchedule