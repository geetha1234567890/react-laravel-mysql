import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { baseUrl } from "../../../utils/baseURL";

export const createTA = createAsyncThunk("taModule/createTA", async (data) => {
  const response = await axios.post(`${baseUrl}/admin/manage_tas`, data);
  return response.data;
});

export const getTA = createAsyncThunk("taModule/getTA", async () => {
  const response = await axios.get(`${baseUrl}/admin/manage_tas`);
  return response.data;
});

export const updateTA = createAsyncThunk(
  "taModule/updateTA",
  async ({ id, data }, { rejectWithValue }) => {
    try {
      const response = await axios.put(
        `${baseUrl}/admin/manage_tas/${id}`,
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

export const deleteTA = createAsyncThunk("taModule/deleteTA", async (id) => {
  await axios.delete(`${baseUrl}/admin/manage_tas/${id}`);
  return id;
});

export const getStudentBatchMapping = createAsyncThunk(
  "taModule/getStudentBatchMapping",
  async () => {
    const response = await axios.get(
      `${baseUrl}/admin/student-batch-mapping/getAllStudentWithBatches`
    );
    console.log("Response : ", response);
    return response.data;
  }
);

export const getBatchMapping = createAsyncThunk(
  "taModule/getBatchMapping",
  async () => {
    const response = await axios.get(`${baseUrl}/admin/batches`);
    console.log("Response : ", response);
    return response.data;
    // return [
    //   {
    //     Student_id: 1,
    //     student_name: "John Doe",
    //     academic_term: "2024",
    //     batch_name: "SARA",
    //   },
    //   {
    //     Student_id: 1,
    //     student_name: "John Doe",
    //     academic_term: "2024",
    //     batch_name: "Ai Course",
    //   },
    //   {
    //     Student_id: 2,
    //     student_name: "John Doe",
    //     academic_term: "2023",
    //     batch_name: "SARA",
    //   },
    //   {
    //     Student_id: 2,
    //     student_name: "John Doe",
    //     academic_term: "2023",
    //     batch_name: "Ai Course",
    //   },
    //   {
    //     Student_id: 3,
    //     student_name: "John Doe",
    //     academic_term: "2023",
    //     batch_name: "Saras Institute",
    //   },
    //   {
    //     Student_id: 4,
    //     student_name: "John Doe",
    //     academic_term: "2024",
    //     batch_name: "Saras USA",
    //   },
    // ];
  }
);

export const showTAMapping = createAsyncThunk(
  "taModule/showTAMapping",
  async () => {
    const response = await axios.get(`${baseUrl}/admin/TAMapping/TAswithActiveStudentnBatches`);
    return response.data;
    // return [
    //   {
    //     id: 1,
    //     name: "Admin1",
    //     username: "admin123",
    //     password: "password123",
    //     location: "delhi",
    //     time_zone: "IST",
    //     gender: "Male",
    //     date_of_birth: "1999-06-15",
    //     highest_qualification: "bachelors",
    //     profile_picture: null,
    //     profile: "i am an admin",
    //     about_me: "hello i am admin1",
    //     is_active: 1,
    //     created_by: 45464,
    //     updated_by: 32144444,
    //     created_at: "2024-06-11T13:43:21.000000Z",
    //     updated_at: "2024-06-25T12:32:24.000000Z",
    //     Active_Batches: 9,
    //     Active_Students: 1,
    //   },
    // ];
  }
);

export const getAssignStudents = createAsyncThunk(
  "taModule/getAssignStudents",
  async (id) => {
    const response = await axios.get(
      `${baseUrl}/admin/TAMapping/${id}/AssignStudents`
    );
    return response.data;
  }
);

export const getAssignBatches = createAsyncThunk(
  "taModule/getAssignBatches",
  async (id) => {
    const response = await axios.get(
      `${baseUrl}/admin/TAMapping/${id}/AssignBatches`
    );
    return response.data;
  }
);

export const toggleAssignStudentStatus = createAsyncThunk(
  "taModule/toggleAssignStudentStatus",
  async ({ id, studentId }) => {
    const response = await axios.put(
      `${baseUrl}/admin/TAMapping/${id}/ActiveDeactiveAssignStudent`,
      { student_id: studentId }
    );
    return response.data;
  }
);

export const toggleAssignBatchStatus = createAsyncThunk(
  "taModule/toggleAssignBatchStatus",
  async ({ id, batchId }) => {
    const response = await axios.put(
      `${baseUrl}/admin/TAMapping/${id}/ActiveDeactiveAssignBatch`,
      { batch_id: batchId }
    );
    return response.data;
  }
);

export const postAssignStudents = createAsyncThunk(
  "taModule/postAssignStudents",
  async ({ id, data }) => {
    const response = await axios.post(
      `${baseUrl}/admin/TAMapping/AssignStudents`,
      data
    );
    return response.data;
  }
);

export const postAssignBatches = createAsyncThunk(
  "taModule/postAssignBatches",
  async ({ id, data }) => {
    const response = await axios.post(
      `${baseUrl}/admin/TAMapping/AssignBatches`,
      data
    );
    return response.data;
  }
);

export const deleteAssignedStudent = createAsyncThunk(
  "taModule/deleteAssignedStudent",
  async (id) => {
    console.log("ID to delete STUDENT : ", id)
    const response = await axios.delete(
      `${baseUrl}/admin/TAMapping/${id.id}/deleteStudent`
    );
    return response.data;
  }
);

export const deleteAssignedBatch = createAsyncThunk(
  "taModule/deleteAssignedBatch",
  async (id) => {
    console.log("ID to delete BATCH : ", id)
    const response = await axios.delete(
      `${baseUrl}/admin/TAMapping/${id.id}/deleteBatch`
    );
    return response.data;
  }
);

export const showTASchedule = createAsyncThunk(
  "taModule/showTaSchedule",
  async () => {
    const response = await axios.get(`${baseUrl}/admin/taschedules`);
    return response.data;
   
  }
);

const initialState = {
  tas: [],
  studentBatchMapping: [],
  batchMapping: [],
  taMapping: null,
  taSchedule: null,
  assignedStudents: [],
  assignedBatches: [],
  loading: false,
  error: null,
  createTAOpen: false,
  editTAOpen: false,
  selectedTA: null,
  successPopup: false,
  assignStudentOpen: false,
  assignBatchOpen: false,
  ta_name: null,
  taID: null,
};

export const taSlice = createSlice({
  name: "taModule",
  initialState,
  reducers: {
    accessTaName(state, action) {
      // console.log("ACTION : ", action);
      // console.log("ACTION PAYLOAD : ", action.payload);
      state.ta_name = action.payload.name;
      state.taID = action.payload.id;
    },
    setSelectedTA(state, action) {
      // console.log("ACTION : ", action);
      state.selectedTA = action.payload;
    },
    openCreateTa(state) {
      state.createTAOpen = true;
    },
    closeCreateTa(state) {
      state.createTAOpen = false;
    },
    openEditTa(state) {
      state.editTAOpen = true;
    },
    closeEditTa(state) {
      state.editTAOpen = false;
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

    handleSelectedStudents(state, action) {
      state.selectedStudents = action.payload;
    },
    handleSelectedBatches(state, action) {
      state.selectedBatches = action.payload;
    },
  },
  extraReducers: (builder) => {
    // Create TA
    builder.addCase(createTA.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(createTA.fulfilled, (state, action) => {
      state.loading = false;
      state.tas = [...state.tas, action.payload];
    });
    builder.addCase(createTA.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Get All TA
    builder.addCase(getTA.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getTA.fulfilled, (state, action) => {
      state.loading = false;
      state.tas = action.payload;
    });
    builder.addCase(getTA.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Update TA
    builder.addCase(updateTA.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(updateTA.fulfilled, (state, action) => {
      state.loading = false;
      const index = state.tas.findIndex((ta) => ta.id === action.payload.id);
      if (index !== -1) {
        state.tas[index] = action.payload;
        // console.log("PAYLOAD ACTION : ", action.payload)
      }
    });
    builder.addCase(updateTA.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Delete TA
    builder.addCase(deleteTA.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(deleteTA.fulfilled, (state, action) => {
      state.loading = false;
      state.tas = state.tas.filter((ta) => ta.id !== action.payload);
    });
    builder.addCase(deleteTA.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });
    // Get Student-Batch Mapping
    builder.addCase(getStudentBatchMapping.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getStudentBatchMapping.fulfilled, (state, action) => {
      state.loading = false;
      // console.log("MAPPING PAYLOAD :", action.payload )
      state.studentBatchMapping = action.payload;
    });
    builder.addCase(getStudentBatchMapping.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // get batch mapping
    builder.addCase(getBatchMapping.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getBatchMapping.fulfilled, (state, action) => {
      state.loading = false;
      // console.log("MAPPING PAYLOAD :", action.payload )
      state.batchMapping = action.payload;
    });
    builder.addCase(getBatchMapping.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Show TA Mapping
    builder.addCase(showTAMapping.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(showTAMapping.fulfilled, (state, action) => {
      // console.log("TAMAPPING : ", action.payload);
      state.loading = false;
      state.taMapping = action.payload;
    });
    builder.addCase(showTAMapping.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Get Assigned Students
    builder.addCase(getAssignStudents.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getAssignStudents.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedStudents = action.payload;
    });
    builder.addCase(getAssignStudents.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Get Assigned Batches
    builder.addCase(getAssignBatches.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(getAssignBatches.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedBatches = action.payload;
    });
    builder.addCase(getAssignBatches.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Toggle Assign Student Status
    builder.addCase(toggleAssignStudentStatus.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(toggleAssignStudentStatus.fulfilled, (state, action) => {
      state.loading = false;
      const updatedStudents = state.assignedStudents.map((student) =>
        student.id === action.payload.id
          ? { ...student, is_active: action.payload.is_active }
          : student
      );
      state.assignedStudents = updatedStudents;
    });
    builder.addCase(toggleAssignStudentStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Toggle Assign Batch Status
    builder.addCase(toggleAssignBatchStatus.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(toggleAssignBatchStatus.fulfilled, (state, action) => {
      state.loading = false;
      const updatedBatches = state.assignedBatches.map((batch) =>
        batch.id === action.payload.id
          ? { ...batch, is_active: action.payload.is_active }
          : batch
      );
      state.assignedBatches = updatedBatches;
    });
    builder.addCase(toggleAssignBatchStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Post Assign Students
    builder.addCase(postAssignStudents.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(postAssignStudents.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedStudents = action.payload;
    });
    builder.addCase(postAssignStudents.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Post Assign Batches
    builder.addCase(postAssignBatches.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(postAssignBatches.fulfilled, (state, action) => {
      state.loading = false;
      state.assignedBatches = action.payload;
    });
    builder.addCase(postAssignBatches.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // delete assigned student
    builder.addCase(deleteAssignedStudent.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(deleteAssignedStudent.fulfilled, (state, action) => {
      state.loading = false;
      // state.assignedStudents = action.payload;
    });
    builder.addCase(deleteAssignedStudent.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // delete assigned Batches
    builder.addCase(deleteAssignedBatch.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(deleteAssignedBatch.fulfilled, (state, action) => {
      state.loading = false;
      // state.assignedStudents = action.payload;
    });
    builder.addCase(deleteAssignedBatch.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });

    // Show TA Mapping
    builder.addCase(showTASchedule.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(showTASchedule.fulfilled, (state, action) => {
      // console.log("TASCHEDULE : ", action.payload);
      state.loading = false;
      state.taSchedule = action.payload.data;
    });
    builder.addCase(showTASchedule.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload || action.error.message;
    });
  },
});

export const {
  openCreateTa,
  closeCreateTa,
  openEditTa,
  closeEditTa,
  setSelectedTA,
  openSuccessPopup,
  accessTaName,
  closeSuccessPopup,
  openAssignStudents,
  closeAssignStudents,
  openAssignBatches,
  closeAssignBatches,
} = taSlice.actions;

export default taSlice.reducer;
