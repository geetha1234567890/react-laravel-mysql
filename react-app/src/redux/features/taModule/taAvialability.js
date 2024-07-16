import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { baseUrl } from "../../../utils/baseURL";

export const getSlots = createAsyncThunk(
  "taAvialability/getSlots",
  async (data) => {
    const response = await axios.post(
      `${baseUrl}/admin/coach-slots/records`,
      data
    );
    return response.data;
  }
);

export const getScheduleSession = createAsyncThunk(
  "taAvialability/getScheduleSession",
  async (data) => {
    // const response = await axios.post(`${baseUrl}/admin/taschedules/get-schedules-records`, data);
    // return response.data;

    return {
      status: true,
      status_code: 200,
      message: "Schedules retrieved successfully.",
      data: [
        {
          id: 6,
          admin_user_id: 2,
          meeting_name: "Team Meeting",
          meeting_url: "http://example.com/meeting",
          date: "2024-07-05 00:00:00",
          slot_id: 1,
          start_time: "11:00:00",
          end_time: "12:00:00",
          time_zone: "IST",
          is_active: 1,
          event_status: "scheduled",
          is_deleted: 0,
          created_by: null,
          updated_by: null,
          Students: [
            {
              student_id: 1,
              student_name: "John Doe",
              academic_term: "2024",
              email: "john.doe2@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 14,
                  batch_name: "Ai Course",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 2,
              student_name: "John Doe",
              academic_term: "2023",
              email: "john.doe@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 14,
                  batch_name: "Ai Course",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 3,
              student_name: "John Doe",
              academic_term: "2023",
              email: "john.doe1@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 4,
              student_name: "John Doe",
              academic_term: "2024",
              email: "john.does@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 12,
                  batch_name: "Saras USA",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
          ],
        },
        {
          id: 7,
          admin_user_id: 2,
          meeting_name: "Team Meeting",
          meeting_url: "http://example.com/meeting",
          date: "2024-07-08 00:00:00",
          slot_id: 2,
          start_time: "11:00:00",
          end_time: "12:00:00",
          time_zone: "IST",
          is_active: 1,
          event_status: "scheduled",
          is_deleted: 0,
          created_by: null,
          updated_by: null,
          Students: [
            {
              student_id: 1,
              student_name: "John Doe",
              academic_term: "2024",
              email: "john.doe2@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 14,
                  batch_name: "Ai Course",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 2,
              student_name: "John Doe",
              academic_term: "2023",
              email: "john.doe@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 14,
                  batch_name: "Ai Course",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 3,
              student_name: "John Doe",
              academic_term: "2023",
              email: "john.doe1@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 1,
                  batch_name: "Saras Institute",
                  branch: "abcd",
                  is_active: 1,
                },
                {
                  batch_id: 13,
                  batch_name: "SARA",
                  branch: "abcd",
                  is_active: 1,
                },
              ],
            },
            {
              student_id: 4,
              student_name: "John Doe",
              academic_term: "2024",
              email: "john.does@example.com",
              phone: "1234567890",
              is_active: 1,
              batches: [
                {
                  batch_id: 12,
                  batch_name: "Saras USA",
                  branch: "gbtrghm",
                  is_active: 1,
                },
              ],
            },
          ],
        },
      ],
    };
  }
);

export const fetchAvailableSlots = createAsyncThunk(
  "taAvialability/fetchAvailableSlots",
  async (data) => {
    // console.log("ID : ", id);
    const response = await axios.post(
      `${baseUrl}/admin/coach-slots/getTACoachSlotForADate`, data
    );
    return response.data;
  }
);

export const deleteFutureSlots = createAsyncThunk(
  "taAvialability/deleteFutureSlots",
  async (id) => {
    console.log("ID : ", id);
    const response = await axios.delete(
      `${baseUrl}/admin/coach-slots/${id.id}`
    );
    return response.data;
  }
);

const initialState = {
  markLeaveOpen: false,
  scheduledSlotsOpen: false,
  scheduledSlotsData: [], // Ensure this is correctly named and initialized
  scheduledSessionData: [], // Ensure this is correctly named and initialized
  availableSlotsData:[],
  scheduledSessionOpen: false,
  cancelSessionOpen: false,
  resheduleSessionOpen: false,
  reasonForLeaveOpen: false,
  deleteFutureSlotOpen: false,
  scheduleNewSession: false,
  createNewSlotOpen: false,
  loading: false,
  error: null,
  schduldeCancelData:null
};

export const taAvailabilitySlice = createSlice({
  name: "taAvialability",
  initialState,
  reducers: {
    openMarkLeave(state) {
      state.markLeaveOpen = true;
    },
    closeMarkLeave(state) {
      state.markLeaveOpen = false;
    },
    openScheduledSlots(state) {
      state.scheduledSlotsOpen = true;
    },
    closeScheduledSlots(state) {
      state.scheduledSlotsOpen = false;
    },
    openScheduledSession(state) {
      state.scheduledSessionOpen = true;
    },
    closeScheduledSession(state) {
      state.scheduledSessionOpen = false;
    },
    openCancelSession(state, action) {
      state.cancelSessionOpen = true;
      state.schduldeCancelData = action.payload
    },
    closeCancelSession(state) {
      state.cancelSessionOpen = false;
    },
    openReasonForLeave(state) {
      state.reasonForLeaveOpen = true;
    },
    closeReasonForLeave(state) {
      state.reasonForLeaveOpen = false;
    },
    openRescheduleSession(state) {
      state.resheduleSessionOpen = true;
    },
    closeRescheduleSession(state) {
      state.resheduleSessionOpen = false;
    },
  },
  extraReducers: (builder) => {
    builder.addCase(getSlots.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getSlots.fulfilled, (state, action) => {
      state.loading = false;
      state.scheduledSlotsData = action.payload?.data;
    });
    builder.addCase(getSlots.rejected, (state, action) => {
      state.loading = false;
      state.error = action.error.message;
    });

    builder.addCase(getScheduleSession.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getScheduleSession.fulfilled, (state, action) => {
      state.loading = false;
      state.scheduledSessionData = action.payload?.data;
    });
    builder.addCase(getScheduleSession.rejected, (state, action) => {
      state.loading = false;
      state.error = action.error.message;
    });

    builder.addCase(fetchAvailableSlots.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(fetchAvailableSlots.fulfilled, (state, action) => {
      state.loading = false;
      state.availableSlotsData = action.payload?.data;
    });
    builder.addCase(fetchAvailableSlots.rejected, (state, action) => {
      state.loading = false;
      state.error = action.error.message;
    });

    builder.addCase(deleteFutureSlots.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(deleteFutureSlots.fulfilled, (state, action) => {
      state.loading = false;
    });
    builder.addCase(deleteFutureSlots.rejected, (state, action) => {
      state.loading = false;
      state.error = action.error.message;
    });
  },
});

export const {
  openMarkLeave,
  closeMarkLeave,
  openScheduledSlots,
  closeScheduledSlots,
  openScheduledSession,
  closeScheduledSession,
  openCancelSession,
  closeCancelSession,
  openReasonForLeave,
  closeReasonForLeave,
  openRescheduleSession,
  closeRescheduleSession,
} = taAvailabilitySlice.actions;

export default taAvailabilitySlice.reducer;
