import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { baseUrl } from "../../../utils/baseURL";

export const showTASchedule = createAsyncThunk(
    "taScheduling/showTaSchedule",
    async () => {
        const response = await axios.get(`${baseUrl}/admin/taschedules`);
        return response.data;
    }
);

export const createTASchedule = createAsyncThunk(
    "taScheduling/createTASchedule",
    async (data) => {
        const response = await axios.post(`${baseUrl}/admin/taschedules`, data);
        return response.data;
    }
)

export const getTaAvailableSlotsFromDate = createAsyncThunk(
    'taScheduling/getTaAvailableSlotsFromDate',
    async (data) => {
        const response = await axios.post(`${baseUrl}/admin/coach-slots/getTACoachSlotForADate`, data);
        return response.data;
    }
)

const initialState = {
    taAvailableSlots: [],
    taSchedule: [],
    loading: false,
    error: null,
    studentBatchMapping: [],
    studentBatchMappingLoading: false,
    studentBatchMappingError: null,
    scheduleSessionOpen: false,
    students: [],
    batches: [],
    taID: null,
    taName: null,
};

const taScheduling = createSlice({
    name: "taScheduling",
    initialState,
    reducers: {
        openScheduleSession(state, action) {
            console.log("Open Action : ", action.payload)
            state.taID = action.payload.id;
            state.taName = action.payload.name;
            if (action.payload.student) {
                state.students = action.payload.student;
            }
            if (action.payload.batches) {
                state.batches = action.payload.batches;
            }
            state.scheduleSessionOpen = true;
        },
        closeScheduleSession(state, action) {
            console.log("Close Action : ", action.payload)
            state.taID = null;
            state.taName = null;
            state.students = [];
            state.batches = [];
            state.scheduleSessionOpen = false;
        },
        clearAvailableSlots(state) {
            state.taAvailableSlots = [];
        },
    },
    extraReducers: (builder) => {
        // Show TA Schedule
        builder.addCase(showTASchedule.pending, (state) => {
            state.loading = true;
        });
        builder.addCase(showTASchedule.fulfilled, (state, action) => {
            state.loading = false;
            state.taSchedule = action.payload.data;
        });
        builder.addCase(showTASchedule.rejected, (state, action) => {
            state.loading = false;
            state.error = action.error.message;
        });

        // Create TA Schedule
        builder.addCase(createTASchedule.pending, (state) => {
            state.loading = true;
        });
        builder.addCase(createTASchedule.fulfilled, (state, action) => {
            state.loading = false;
            state.taSchedule = action.payload.data;
        });
        builder.addCase(createTASchedule.rejected, (state, action) => {
            state.loading = false;
            state.error = action.error.message;
        });

        // Get TA Available Slots From Date
        builder.addCase(getTaAvailableSlotsFromDate.pending, (state) => {
            state.loading = true;
        });
        builder.addCase(getTaAvailableSlotsFromDate.fulfilled, (state, action) => {
            state.loading = false;
            state.taAvailableSlots = action.payload.data;
        });
        builder.addCase(getTaAvailableSlotsFromDate.rejected, (state, action) => {
            state.loading = false;
            state.error = action.error.message;
        });
    },
});

export const {
    openScheduleSession,
    closeScheduleSession,
} = taScheduling.actions

export default taScheduling.reducer