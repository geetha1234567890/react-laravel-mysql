import { Box, Button, Checkbox, DialogContent, FormControl, FormControlLabel, FormGroup, Grid, Radio, RadioGroup } from '@mui/material';
import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux';
import CustomTextField from '../CustomFields/CustomTextField';
import PopUpTable from '../CommonComponent/PopUpTable';
import CustomTimeField from '../CustomFields/CustomTimeField';
import CustomDateField from '../CustomFields/CustomDateField';
import ReusableDialog from '../CustomFields/ReusableDialog';
import CustomFormControl from '../CustomFields/CustomFromControl';
import { timeZones, transformedTimeZones, validateTimeZone } from '../CustomFields/FormOptions';
import { closeScheduleSession, createTASchedule, getTaAvailableSlotsFromDate } from '../../redux/features/taModule/taScheduling';
import { openAssignBatches, openAssignStudents } from '../../redux/features/taModule/taSlice';
import { getSlots } from '../../redux/features/taModule/taAvialability';
import { useForm } from 'react-hook-form';

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

const headers = ['S. No.', 'Slot Date', 'From Time', 'To Time', 'Select'];
const weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

const actionButtons = [
    {
        type: "button",
    },
];

const Schedule = () => {
    const [fromDate, setFromDate] = useState(null);
    const [toDate, setToDate] = useState(null);
    const [fromTime, setFromTime] = useState(null);
    const [toTime, setToTime] = useState(null);
    const [timezone, setTimezone] = useState('');
    const [repeat, setRepeat] = useState('onetime');
    const [selectedDays, setSelectedDays] = useState([]);
    const [taSlotData, setTaSlotData] = useState([{}]);
    const [selectedSlot, setSelectedSlot] = useState([{}]);

    const dispatch = useDispatch()
    const { scheduleSessionOpen, taID, taName, students, batches, taAvailableSlots } = useSelector((state) => state.taScheduling);
    const { register, handleSubmit, formState: { errors } } = useForm();

    useEffect(() => {
        if (fromDate) {
            dispatch(getTaAvailableSlotsFromDate({ admin_user_id: taID, date: fromDate }));
        }
    }, [fromDate]);

    useEffect(() => {
        if (taAvailableSlots && taAvailableSlots.length > 0) {
            const transformData = taAvailableSlots.map((item) => ({
                "S. No.": item.id,
                "Slot Date": item.slot_date,
                "From Time": item.from_time,
                "To Time": item.to_time,
                //'Time Zone': item.timezone,
            }));
            setTaSlotData(transformData);
        }
    }, [taAvailableSlots]);


    const handleDayChange = (day) => {
        setSelectedDays((prev) => {
            if (prev.includes(day)) {
                return prev.filter((d) => d !== day);
            } else {
                return [...prev, day];
            }
        });
    };

    const handleSelectSlots = (id) => {
        console.log("ID : ", id)
        setSelectedSlot((prev) => {
            if (prev.includes(id)) {
                return prev.filter((sid) => sid !== id);
            } else {
                return [...prev, id];
                //return id;
            }
        });
    }

    const handleAssignStudents = () => {
        // dispatch(closeScheduleSession())
        dispatch(openAssignStudents());
    }

    const handleAssignBatches = () => {
        // dispatch(closeScheduleSession())
        dispatch(openAssignBatches());
    }

    const onSubmit = async (formData) => {
        console.log("formData : ", formData)
        const studentId = students.map((student) => student.id)
        const batchId = batches.map((batch) => batch.id)
        console.log("students Id : ", studentId)
        console.log("batch Id : ", batchId)
        console.log("selected Daysss : ", selectedDays)
        console.log("selected Slot : ", selectedSlot, selectedSlot[1])

        formData.start_time = fromTime;
        formData.end_time = toTime;
        formData.timezone = timezone;
        formData.repeat = repeat;
        formData.schedule_date = fromDate;
        formData.end_date = toDate;
        formData.admin_user_id = taID;
        formData.slot_id = selectedSlot[1];
        // formData.slot_id = 2;
        formData.event_status = "scheduled";
        formData.weeks = selectedDays;
        formData.timezone = "IST";
        formData.studentId = studentId;
        formData.batchId = batchId;

        dispatch(createTASchedule({ ...formData }))
        dispatch(closeScheduleSession())
    };


    const content = (
        <Box display="flex" justifyContent="center" alignItems="center" sx={{ height: '100%', width: '100%' }}>
            <Grid container spacing={3} justifyContent="center">
                <Grid item xs={12} display="flex" justifyContent="center">
                    <Box display="flex" justifyContent="center" gap={2} sx={{ mb: 3 }}>
                        <Button
                            variant="contained"
                            onClick={handleAssignStudents}
                            sx={{
                                backgroundColor: "#F56D3B",
                                color: "white",
                                height: "60px",
                                width: "201px",
                                borderRadius: "50px",
                                textTransform: "none",
                                padding: "18px 30px",
                                fontWeight: "700",
                                fontSize: "16px",
                                "&:hover": {
                                    backgroundColor: '#D4522A',
                                },
                            }}
                        >
                            Students
                        </Button>
                        <Button
                            variant="outlined"
                            onClick={handleAssignBatches}
                            sx={{
                                backgroundColor: "white",
                                color: "#F56D3B",
                                height: "60px",
                                width: "194px",
                                border: "2px solid #F56D3B",
                                borderRadius: "50px",
                                textTransform: "none",
                                fontWeight: "700",
                                fontSize: "16px",
                                padding: "18px 30px",
                                "&:hover": {
                                    backgroundColor: '#F56D3B',
                                    color: 'white',
                                },
                            }}
                        >
                            Batches
                        </Button>
                    </Box>
                </Grid>
    
                <form onSubmit={handleSubmit(onSubmit)} noValidate>
                    <Box display="flex" justifyContent="center" m={4}>
                        <Grid container spacing={3} justifyContent="center">
                            <Grid item xs={12} sm={6} display="flex" justifyContent="center">
                                <CustomDateField
                                    label="From Date"
                                    value={fromDate}
                                    onChange={setFromDate}
                                    name="schedule_date"
                                    register={register}
                                    validation={{ required: 'From Date is required' }}
                                    sx={{ width: '100%' }}
                                />
                            </Grid>
    
                            {fromDate && (
                                <>
                                    {taSlotData.length === 0 ? (
                                        <Grid item xs={12} display="flex" justifyContent="center">
                                            <DialogContent>No Slot Available</DialogContent>
                                        </Grid>
                                    ) : (
                                        <>
                                            <Grid item xs={12} display="flex" justifyContent="center">
                                                <PopUpTable
                                                    headers={headers}
                                                    initialData={taSlotData}
                                                    onRowClick={handleSelectSlots}
                                                    selectedBox={selectedSlot}
                                                />
                                            </Grid>
    
                                            <Grid container spacing={3} sx={{ pt: 3 }} justifyContent="center">
                                                <Grid item xs={12} display="flex" justifyContent="center">
                                                    <CustomTextField
                                                        label="Meeting Name"
                                                        name="meeting_name"
                                                        placeholder="Enter Meeting Name"
                                                        register={register}
                                                        validation={{ required: 'Meeting Name is required' }}
                                                        errors={errors}
                                                    />
                                                </Grid>
                                                <Grid item xs={12} display="flex" justifyContent="center">
                                                    <CustomTextField
                                                        label="Meeting URL"
                                                        name="meeting_url"
                                                        placeholder="Enter Meeting URL"
                                                        register={register}
                                                        validation={{ required: 'Meeting URL is required' }}
                                                        errors={errors}
                                                    />
                                                </Grid>
                                                <Grid item xs={12} sm={6} display="flex" justifyContent="center">
                                                    <CustomTimeField
                                                        label="From Time"
                                                        name="start_time"
                                                        value={fromTime}
                                                        onChange={setFromTime}
                                                        validation={{ required: 'From Time is required' }}
                                                        errors={errors}
                                                    />
                                                </Grid>
                                                <Grid item xs={12} sm={6} display="flex" justifyContent="center">
                                                    <CustomTimeField
                                                        label="End Time"
                                                        name="end_time"
                                                        value={toTime}
                                                        onChange={setToTime}
                                                        validation={{ required: 'End Time is required' }}
                                                        errors={errors}
                                                    />
                                                </Grid>
                                                <Grid item xs={12} sm={6} display="flex" justifyContent="center">
                                                    <CustomFormControl
                                                        label="Select Timezone"
                                                        name="timezone"
                                                        value={timezone}
                                                        controlProps={{
                                                            select: true,
                                                            fullWidth: true,
                                                            value: timezone,
                                                            onChange: (e) => setTimezone(e.target.value),
                                                        }}
                                                        register={register}
                                                        validation={{ validate: validateTimeZone }}
                                                        errors={errors}
                                                        options={transformedTimeZones}
                                                    />
                                                </Grid>
                                            </Grid>
    
                                            <Grid container spacing={3} justifyContent="center" sx={{ pt: 3 }}>
                                                <Grid item xs={12} display="flex" justifyContent="center">
                                                    <FormControl component="fieldset">
                                                        <RadioGroup
                                                            row
                                                            value={repeat}
                                                            onChange={(e) => setRepeat(e.target.value)}
                                                            sx={{ justifyContent: 'center' }}
                                                        >
                                                            <FormControlLabel
                                                                value="onetime"
                                                                control={<Radio />}
                                                                label="One-Time"
                                                            />
                                                            <FormControlLabel
                                                                value="recurring"
                                                                control={<Radio />}
                                                                label="Recurring"
                                                            />
                                                        </RadioGroup>
                                                    </FormControl>
                                                </Grid>
                                            </Grid>
    
                                            {repeat === 'recurring' && (
                                                <>
                                                    <Grid container spacing={3} justifyContent="center" sx={{ pt: 3 }}>
                                                        <Grid item xs={12}>
                                                            <FormControl component="fieldset">
                                                                <FormGroup row>
                                                                    {weekDays.map((day) => (
                                                                        <FormControlLabel
                                                                            key={day}
                                                                            control={
                                                                                <Checkbox
                                                                                    checked={selectedDays.includes(day)}
                                                                                    onChange={() => handleDayChange(day)}
                                                                                    name={day}
                                                                                />
                                                                            }
                                                                            label={day}
                                                                        />
                                                                    ))}
                                                                </FormGroup>
                                                            </FormControl>
                                                        </Grid>
                                                    </Grid>
                                                    <Grid item xs={12} sm={6} display="flex" justifyContent="center">
                                                        <CustomDateField
                                                            label="To Date"
                                                            value={toDate}
                                                            onChange={setToDate}
                                                            name="end_date"
                                                            register={register}
                                                            validation={{ required: 'To Date is required' }}
                                                            sx={{ width: '100%' }}
                                                        />
                                                    </Grid>
                                                </>
                                            )}
                                            <Grid item xs={12} display="flex" justifyContent="center">
                                                <Button
                                                    type="submit"
                                                    variant="contained"
                                                    style={{
                                                        borderRadius: "50px",
                                                        padding: "18px 30px",
                                                        marginTop: 30,
                                                        backgroundColor: "#F56D3B",
                                                        height: "60px",
                                                        width: "121px",
                                                        fontSize: "16px",
                                                        fontWeight: "700px",
                                                        text: "#FFFFFF",
                                                    }}
                                                >
                                                    Submit
                                                </Button>
                                            </Grid>
                                        </>
                                    )}
                                </>
                            )}
                        </Grid>
                    </Box>
                </form>
            </Grid>
        </Box>
    );
    

    const actions = (
        <CustomButton
            onClick={handleSubmit}
            backgroundColor='#F56D3B'
            borderColor='#F56D3B'
            color='#FFFFFF'
        >
            Submit
        </CustomButton>
    );

    return (
        <ReusableDialog
            open={scheduleSessionOpen}
            handleClose={() => dispatch(closeScheduleSession())}
            title={`Schedule Session for ${taName}`}
            content={content}
        // actions={actions}
        />
    )
}

export default Schedule