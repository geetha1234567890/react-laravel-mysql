import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { baseUrl } from "../../../utils/baseURL";

export const getAllCoachTemplates = createAsyncThunk(
  "coachTemplate/getAllCoachTemplates",
  async () => {
    const response = await axios.get(`${baseUrl}/admin/coaching-templates`);
    return response.data;
  }
);

export const createCoachTemplate = createAsyncThunk(
  "coachTemplate/createCoachTemplate",
  async (data) => {
    const response = await axios.post(`${baseUrl}/admin/store-template`, data);
    return response.data;
  }
);

export const getAllCoachTemplateModules = createAsyncThunk(
  "coachTemplate/getAllCoachTemplateModules",
  async () => {
    const response = await axios.get(
      `${baseUrl}/admin/coaching-templates/modules`
    );
    return response.data;
  }
);

export const createCoachTemplateModule = createAsyncThunk(
  "coachTemplate/createCoachTemplateModule",
  async (data) => {
    const response = await axios.post(
      `${baseUrl}/admin/coaching-templates/store-modules`,
      data
    );
    return response.data;
  }
);

export const updateCoachTemplateModule = createAsyncThunk(
  "coachTemplate/updateCoachTemplateModule",
  async (data) => {
    const response = await axios.put(
      `${baseUrl}/admin/coaching-templates/update-modules`,
      data
    );
    return response.data;
  }
);

export const createCoachTemplateActivity = createAsyncThunk(
  "coachTemplate/createCoachTemplateActivity",
  async (data) => {
    const response = await axios.post(
      `${baseUrl}/admin/coaching-templates/store-activity`,
      data
    );
    return response.data;
  }
);
const initialState = {
  coachesTemplateList: [],
  coachTemplates: [],
  loading: false,
  error: null,
  createCoachTemplateOpen: false,
  editCoachTemplateOpen: false,
  selectedCoach: null,
  openModulePopUp: false,
  openActivityPopUp: false,
  openEditModulePopUp: false,
  assignStudentOpen: false,
  assignBatchOpen: false,
  template_name: null,
  templateId: null,
  createCoachTemplateOpen: false,
  editCoachTemplateOpen: false,
};

export const coachTemplateSlice = createSlice({
  name: "coachTemplate",
  initialState,
  reducers: {
    accessCoachTemplateName(state, action) {
      //   console.log("ACTION : ", action);
      //   console.log("ACTION PAYLOAD : ", action.payload);
      state.template_name = action.payload.name;
      state.templateId = action.payload.id;
    },
    openCreateTemplateCoach(state) {
      state.createCoachTemplateOpen = true;
    },
    closeCreateTemplateCoach(state) {
      state.createCoachTemplateOpen = false;
    },
    openEditTemplateCoach(state) {
      state.editCoachTemplateOpen = true;
    },
    closeEditTemplateCoach(state) {
      state.editCoachTemplateOpen = false;
    },
    openTemplateModulePopup(state) {
      state.openModulePopUp = true;
    },
    closeTemplateModulePopup(state) {
      state.openModulePopUp = false;
    },

    openTemplateActivityPopup(state) {
      state.openActivityPopUp = true;
    },
    closeTemplateActivityPopup(state) {
      state.openActivityPopUp = false;
    },

    openEditModulePopup(state) {
      state.openEditModulePopUp = true;
    },
    closeEditModulePopup(state) {
      state.openEditModulePopUp = false;
    },
  },
  extraReducers: (builder) => {
    // getAllCoachTemplates
    builder
      .addCase(getAllCoachTemplates.pending, (state) => {
        state.loading = true;
      })
      .addCase(getAllCoachTemplates.fulfilled, (state, action) => {
        state.loading = false;
        state.coachTemplates = action.payload.data;
      })
      .addCase(getAllCoachTemplates.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });

    // createCoachTemplate
    builder
      .addCase(createCoachTemplate.pending, (state) => {
        state.loading = true;
      })
      .addCase(createCoachTemplate.fulfilled, (state, action) => {
        state.loading = false;
        state.coachTemplates.push(action.payload.data);
      })
      .addCase(createCoachTemplate.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });

    // getAllCoachTemplateModules
    builder
      .addCase(getAllCoachTemplateModules.pending, (state) => {
        state.loading = true;
      })
      .addCase(getAllCoachTemplateModules.fulfilled, (state, action) => {
        state.loading = false;
        state.coachTemplates = action.payload.data;
      })
      .addCase(getAllCoachTemplateModules.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });

    // createCoachTemplateModule
    builder
      .addCase(createCoachTemplateModule.pending, (state) => {
        state.loading = true;
      })
      .addCase(createCoachTemplateModule.fulfilled, (state, action) => {
        state.loading = false;
        state.coachTemplates.push(action.payload.data);
      })
      .addCase(createCoachTemplateModule.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });

    // updateCoachTemplateModule
    builder
      .addCase(updateCoachTemplateModule.pending, (state) => {
        state.loading = true;
      })
      .addCase(updateCoachTemplateModule.fulfilled, (state, action) => {
        state.loading = false;
        const index = state.coachTemplates.findIndex(
          (coachTemplate) => coachTemplate.id === action.payload.id
        );
        if (index !== -1) {
          state.coachTemplates[index] = action.payload;
        }
      })
      .addCase(updateCoachTemplateModule.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });

    // createCoachTemplateActivity
    builder
      .addCase(createCoachTemplateActivity.pending, (state) => {
        state.loading = true;
      })
      .addCase(createCoachTemplateActivity.fulfilled, (state, action) => {
        state.loading = false;
        state.coachTemplates.push(action.payload.data);
      })
      .addCase(createCoachTemplateActivity.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message;
      });
  },
});

export const {
  openCreateTemplateCoach,
  closeCreateTemplateCoach,
  openEditTemplateCoach,
  closeEditTemplateCoach,
  accessCoachTemplateName,
  openTemplateModulePopup,
  closeTemplateModulePopup,
  openTemplateActivityPopup,
  closeTemplateActivityPopup,
  openEditModulePopup,
  closeEditModulePopup
} = coachTemplateSlice.actions;

export default coachTemplateSlice.reducer;
