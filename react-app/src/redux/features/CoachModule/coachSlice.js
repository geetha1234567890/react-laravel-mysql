import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { baseUrl } from "../../../utils/baseURL";

export const createCoach = createAsyncThunk(
  "coachModule/createCoach",
  async (data) => {
    const response = await axios.post(`${baseUrl}/admin/manage_coaches`, data);
    return response.data;
  }
);

export const getCoach = createAsyncThunk("coachModule/getCoach", async () => {
  const response = await axios.get(`${baseUrl}/admin/manage_coaches`);
  return response.data;
});

export const updateCoach = createAsyncThunk(
  "coachModule/updateCoach",
  async ({ id, data }, { rejectWithValue }) => {
    try {
      const response = await axios.put(
        `${baseUrl}/admin/manage_coaches/${id}`,
        data
      );
      console.log("API Response: ", response.data);
      return response.data;
    } catch (error) {
      console.error(
        "API Error: ",
        error.response ? error.response.data : error.message
      );
      return rejectWithValue(
        error.response ? error.response.data : error.message
      );
    }
  }
);

export const deleteCoach = createAsyncThunk(
  "coachModule/deleteCoach",
  async (id) => {
    await axios.delete(`${baseUrl}/admin/manage_coaches/${id}`);
    return id;
  }
);
export const showCAMapping = createAsyncThunk(
  "coachModule/showCAMapping",
  async () => {
    // const response = await axios.get(`${baseUrl}/admin/CoachMapping/CoachswithActiveStudentnBatches`);
    // return response.data;
    return{
    
      data: [
        {
          id: 5,
          name: "sample coach2",
          username: "xyz-coach2",
          is_active: 1,
          Active_Batches: 2,
          Active_Students: 3
        },
        {
          id: 6,
          name: "sample coach3",
          username: "xyz-coach3",
          is_active: 1,
          Active_Batches: 1,
          Active_Students: 10
        },
        {
          id: 7,
          name: "sample coach4",
          username: "xyz-coach4",
          is_active: 0,
          Active_Batches: 0,
          Active_Students: 0
        },
        {
          id: 8,
          name: "sample coach5",
          username: "xyz-coach5",
          is_active: 1,
          Active_Batches: 3,
          Active_Students: 15
        },
        {
          id: 9,
          name: "sample coach6",
          username: "xyz-coach6",
          is_active: 1,
          Active_Batches: 2,
          Active_Students: 8
        },
        {
          id: 10,
          name: "sample coach7",
          username: "xyz-coach7",
          is_active: 0,
          Active_Batches: 0,
          Active_Students: 0
        },
        {
          id: 11,
          name: "sample coach8",
          username: "xyz-coach8",
          is_active: 1,
          Active_Batches: 4,
          Active_Students: 20
        },
        {
          id: 12,
          name: "sample coach9",
          username: "xyz-coach9",
          is_active: 1,
          Active_Batches: 1,
          Active_Students: 5
        },
        {
          id: 13,
          name: "sample coach10",
          username: "xyz-coach10",
          is_active: 1,
          Active_Batches: 2,
          Active_Students: 6
        },
        {
          id: 14,
          name: "sample coach11",
          username: "xyz-coach11",
          is_active: 1,
          Active_Batches: 3,
          Active_Students: 12
        },
        {
          id: 15,
          name: "sample coach12",
          username: "xyz-coach12",
          is_active: 0,
          Active_Batches: 0,
          Active_Students: 0
        }
      ]
    };
  }
);
export const getCoachAssignStudents = createAsyncThunk(
  "coachModule/getCoachAssignStudents",
  async (id) => {
    const response = await axios.get(
      `${baseUrl}/admin/CoachMapping/${id}/AssignStudents`
    );
    return response.data;
  }
);
export const getCoachAssignBatches = createAsyncThunk(
  "coachModule/getCoachAssignBatches",
  async (id) => {
    const response = await axios.get(
      `${baseUrl}/admin/CoachMapping/${id}/AssignBatches`
    );
    return response.data;
  }
);

const initialState = {
  coaches: [],
  studentBatchMapping: null,
  batchMapping: null,
  coachMapping: null,
  coachSchedule: null,
  assignedStudents: [],
  assignedBatches: [],
  loading: false,
  error: null,
  createCoachOpen: false,
  editCoachOpen: false,
  selectedCoach: null,
  successPopup: false,
  assignStudentOpen: false,
  assignBatchOpen: false,
  coach_name: null,
  coachID: null,
};

export const coachSlice= createSlice({
  name: "coachModule",
  initialState,
  reducers: {
    accessCoachName(state, action) {
    //   console.log("ACTION : ", action);
    //   console.log("ACTION PAYLOAD : ", action.payload);
      state.coach_name = action.payload.name;
      state.coachID = action.payload.id;
    },
    setSelectedCoach(state, action) {
    //   console.log("ACTION : ", action);
      state.selectedCoach = action.payload;
    },
    openCreateCoach(state) {
      state.createCoachOpen = true;
    },
    closeCreateCoach(state) {
      state.createCoachOpen = false;
    },
    openEditCoach(state) {
      state.editCoachOpen = true;
    },
    closeEditCoach(state) {
      state.editCoachOpen = false;
    },

    openSuccessPopup(state) {
      state.successPopup = true;
    },
    closeSuccessPopup(state) {
      state.successPopup = false;
    },
    openAssignStudents(state) {
      state.assignStudentOpen = true;
    },
    closeAssignStudents(state) {
      state.assignStudentOpen = false;
    },
    openAssignBatches(state) {
      state.assignBatchOpen = true;
    },
    closeAssignBatches(state) {
      state.assignBatchOpen = false;
    },
  },
  extraReducers: (builder) => {
    // Create COACH
    builder.addCase(createCoach.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(createCoach.fulfilled, (state, action) => {
      state.loading = false;
      state.coaches = [...state.coaches, action.payload];
    });
    builder.addCase(createCoach.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Get All COACH
    builder.addCase(getCoach.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getCoach.fulfilled, (state, action) => {
      state.loading = false;
      state.coaches = action.payload;
    });
    builder.addCase(getCoach.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Update Coach
    builder.addCase(updateCoach.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(updateCoach.fulfilled, (state, action) => {
      state.loading = false;
      const index = state.coaches.findIndex((coach) => coach.id === action.payload.id);
      if (index !== -1) {
        state.coaches[index] = action.payload;
      }
    });
    builder.addCase(updateCoach.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Delete Coach
    builder.addCase(deleteCoach.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(deleteCoach.fulfilled, (state, action) => {
      state.loading = false;
      state.coaches = state.coaches.filter((coach) => coach.id !== action.payload);
    });
    builder.addCase(deleteCoach.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });
    // Get Assigned Students
    builder.addCase(getCoachAssignStudents.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getCoachAssignStudents.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedStudents = action.payload;
    });
    builder.addCase(getCoachAssignStudents.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });
    
     // Get Assigned Batches
     builder.addCase(getCoachAssignBatches.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getCoachAssignBatches.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedBatches = action.payload;
    });
    builder.addCase(getCoachAssignBatches.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

     // Show CA Mapping
     builder.addCase(showCAMapping.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(showCAMapping.fulfilled, (state, action) => {
      console.log("action " , action.payload);
      state.loading = false;
      state.coachMapping = action.payload?.data;
    });
    builder.addCase(showCAMapping.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });
  },

  
});


export const {
    openCreateCoach,
    closeCreateCoach,
    openEditCoach,
    closeEditCoach,
    setSelectedCoach,
    openSuccessPopup,
    accessCoachName,
    closeSuccessPopup,
    openAssignStudents,
    closeAssignStudents,
    openAssignBatches,
    closeAssignBatches,
  } = coachSlice.actions;
  
  export default coachSlice.reducer;
