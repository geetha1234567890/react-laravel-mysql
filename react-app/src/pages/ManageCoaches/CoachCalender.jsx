import { Box, DialogActions, Grid, Typography, Button } from '@mui/material'
import React, { useState } from 'react'
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';
import Calendar from '../../components/Calender/indexCalender';
import MarkLeave from '../../components/availability/MarkLeave';
import DeleteAllSlots from '../../components/availability/DeleteAllSlots';
import CreateNewSlot from '../../components/availability/CreateNewSlot';

const CoachCalender = () => {
    const [sheduleNewSession, setSheduleNewSession] = useState(false)
    const [markLeave, setMarkLeave] = useState(false)
    const [deleteFutureSlots, setDeleteFutureSlots] = useState(false)
    const [createNewSlot, setCreateNewSlot] = useState(false)

    const handleScheduleNewSession = () => {
        setSheduleNewSession(true)
    }

    const handleMarkLeave = () => {
        setMarkLeave(true)
    }

    const handleDeleteFutureSlots = () => {
        setDeleteFutureSlots(true)
    }

    const handleCreateNewSlot = () => {
        setCreateNewSlot(true)
    }

    return (
        <Box sx={{ backgroundColor: '#f8f9fa', p: 3 }}>
            <DialogActions sx={{ p: 2 }}>
                <Grid container alignItems="center">
                    <Grid item xs>
                        <Typography variant='h4' sx={{ mb: 4 }}>
                            Coach Name Calender
                        </Typography>
                    </Grid>
                    <Grid item>
                        <Box display="flex" justifyContent="center" gap={2}>
                            <Button
                                variant="contained"
                                onClick={handleScheduleNewSession}
                                sx={{
                                    width: '195px',
                                    height: '50px',
                                    backgroundColor: '#4E18A5',
                                    color: '#FFFFFF',
                                    font : 'Nodemi',
                                    fontWeight : '700',
                                    fontSize : '16px',
                                    borderRadius: '50px',
                                    padding: "18px 25px"
                                }}
                            >
                                <AddCircleOutlineIcon />
                                Schedule New Session
                            </Button>

                            <Button
                                variant="contained"
                                onClick={handleMarkLeave}
                                sx={{
                                    width: '255px',
                                    height: '50px',
                                    backgroundColor: '#FFFFFF',
                                    color: '#F56D3B',
                                    borderRadius: '50px',
                                    font : 'Nodemi',
                                    fontWeight : '700',
                                    fontSize : '16px',
                                    padding: "18px 25px",
                                    border: '1px solid #F56D3B'
                                }}
                            >
                                Mark Leave
                            </Button>

                            <Button
                                variant="contained"
                                onClick={handleDeleteFutureSlots}
                                sx={{
                                    width: '341px',
                                    height: '50px',
                                    backgroundColor: '#FFFFFF',
                                    color: '#F56D3B',
                                    borderRadius: '50px',
                                    padding: "18px 25px",
                                    border: '1px solid #F56D3B',
                                    font : 'Nodemi',
                                    fontWeight : '700',
                                    fontSize : '16px',
                                }}
                            >
                                Delete All Future Slots
                            </Button>

                            <Button
                                variant="contained"
                                onClick={handleCreateNewSlot}
                                sx={{
                                    width: '225px',
                                    height: '50px',
                                    backgroundColor: '#F56D3B',
                                    color: '#FFFFFF',
                                    borderRadius: '50px',
                                    padding: "18px 25px",
                                    font : 'Nodemi',
                                    fontSize : '16px',
                                    fontWeight : '700'
                                }}
                            >
                                {/* <AddCircleOutlineIcon /> */}
                                Create New Slot
                            </Button>
                        </Box>
                    </Grid>
                </Grid>
            </DialogActions>
            <Calendar />
            {markLeave && <MarkLeave open={markLeave} handleClose={() => setMarkLeave(false)} />}
            {deleteFutureSlots && <DeleteAllSlots open={deleteFutureSlots} handleClose={() => setDeleteFutureSlots(false)} />}
            {createNewSlot && <CreateNewSlot open={createNewSlot} handleClose={() => setCreateNewSlot(false)} />}
        </Box>
    )
}

export default CoachCalender