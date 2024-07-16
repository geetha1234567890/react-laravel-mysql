import { Box, DialogActions, Grid, Typography, Button } from '@mui/material'
import React, { useState } from 'react'
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';
import Calendar from '../../components/Calender/indexCalender';
import CalendarNew from '../../components/Calender/IndexCalenderNew';
import CalendarComponent from '../../components/Calender/BigCalendar';
import MarkLeave from '../../components/availability/MarkLeave';
import DeleteAllSlots from '../../components/availability/DeleteAllSlots';
import CreateNewSlot from '../../components/availability/CreateNewSlot';
import ScheduleSession from '../../components/availability/ScheduleSession';
import { openMarkLeave, closeMarkLeave } from '../../redux/features/taModule/taAvialability';
import { useDispatch, useSelector } from 'react-redux';
import Slots from '../../components/availability/Slots';
import ScheduledSessions from '../../components/availability/ScheduledSessions';
import CancelSchedule from '../../components/availability/CancelSchedule';
import ReasonForLeave from '../../components/availability/ReasonForLeave';
import ReschedulingSession from '../../components/availability/ReschedulingSession';
import { PickersInputBaseSectionsContainer } from '@mui/x-date-pickers/PickersTextField/PickersInputBase/PickersInputBase';
import NewCal from '../../components/Calender/IndexCalenderNew';
import { add } from 'date-fns';
import { useParams } from 'react-router-dom';

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
                // padding: "18px 25px",
                border: `1.5px solid ${borderColor}`,
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

const TaCalender
    = () => {
        const dispatch = useDispatch();
        const {id , name} = useParams()
        const [sheduleNewSession, setSheduleNewSession] = useState(false)
        const [deleteFutureSlots, setDeleteFutureSlots] = useState(false)
        const [createNewSlot, setCreateNewSlot] = useState(false)
        const { 
            markLeaveOpen, 
            scheduledSlotsOpen, 
            scheduledSessionOpen, 
            cancelSessionOpen,
            reasonForLeaveOpen,
            resheduleSessionOpen,
        } = useSelector((state) => state.taAvialability);
        //calendar
        const [eventsList, setEventsList] = useState([]);
        const addEvent = (title, startDateTime, endDateTime) => {
            const newStart = new Date(startDateTime);
            const newEnd = new Date(endDateTime);
            setEventsList(prev => [...prev, { title, start: newStart, end: newEnd }]);
        };
        // const handleSelectEvent = event => {
        //     if (window.confirm(`Are you sure you want to delete the event '${event.title}'?`)) {
        //         setEventsList(prev => {
        //             const updatedEvents = prev.filter(e => e.start !== event.start || e.end !== event.end || e.title !== event.title);
        //             return updatedEvents;
        //           });
        //     }
        //   };
    
    
        const handleScheduleNewSession = () => {
            console.log("Pressed")
            setSheduleNewSession(true)
        }

        const handleMarkLeave = () => {
            dispatch(openMarkLeave());
        }

        const handleDeleteFutureSlots = () => {
            setDeleteFutureSlots(true)
        }

        const handleCreateNewSlot = () => {
            setCreateNewSlot(true)
        }

        // console.log("markLeaveOpen", markLeaveOpen);
        // console.log("scheduledSlotsOpen", scheduledSlotsOpen)
        // console.log("scheduledSessionOpen", scheduledSessionOpen)
        // console.log("cancelSessionOpen", cancelSessionOpen)

        return (
            <Box sx={{ backgroundColor: '#f8f9fa', p: 3 }}>
                <DialogActions sx={{ p: 2 }}>
                    <Grid container alignItems="center">
                        <Grid item xs>
                            <Typography variant='h4' sx={{ mb: 4 }}>
                               {name} Calender 
                            </Typography>
                        </Grid>
                        <Grid item>
                            <Box display="flex" justifyContent="center" gap={2}>
                                <CustomButton
                                    onClick={handleScheduleNewSession}
                                    color='#FFFFFF'
                                    backgroundColor='#4E18A5'
                                    borderColor='#4E18A5'
                                >
                                    <AddCircleOutlineIcon />
                                    Schedule New Session
                                </CustomButton>

                                <CustomButton
                                    onClick={handleMarkLeave}
                                    color='#F56D3B'
                                    backgroundColor='#FFFFFF'
                                    borderColor='#F56D3B'
                                >
                                    Mark Leave
                                </CustomButton>

                                <CustomButton
                                    onClick={handleDeleteFutureSlots}
                                    color='#F56D3B'
                                    backgroundColor='#FFFFFF'
                                    borderColor='#F56D3B'
                                >
                                    Delete All Future Slots
                                </CustomButton>

                                <CustomButton
                                    color='#FFFFFF'
                                    backgroundColor='#F56D3B'
                                    borderColor='#F56D3B'
                                    onClick={setCreateNewSlot}
                                >
                                    {/* <AddCircleOutlineIcon /> */}
                                    Create New Slot
                                </CustomButton>
                            </Box>
                        </Grid>
                    </Grid>
                </DialogActions>
                <CalendarComponent eventsList={eventsList} addEvent={addEvent} /*handleSelectEvent={handleSelectEvent}*/ />
                {sheduleNewSession && <ScheduleSession open={sheduleNewSession} handleClose={() => setSheduleNewSession(false)} />}
                {markLeaveOpen && <MarkLeave id={id} name={name} />}
                {scheduledSlotsOpen && <Slots  id={id} name={name}/>}
                {scheduledSessionOpen && <ScheduledSessions id={id} name={name}/> }
                {cancelSessionOpen && <CancelSchedule id={id} name={name}/>}
                {reasonForLeaveOpen && <ReasonForLeave id={id} name={name}/> }
                {resheduleSessionOpen && <ReschedulingSession id={id} name={name} /> }
                {deleteFutureSlots && <DeleteAllSlots open={deleteFutureSlots} handleClose={() => setDeleteFutureSlots(false)} id={id} name={name} />}
                {createNewSlot && <CreateNewSlot open={createNewSlot} handleClose={() => setCreateNewSlot(false)} addEvent={addEvent} id={id} name={name} />}
            </Box>
        )
    }

export default TaCalender
