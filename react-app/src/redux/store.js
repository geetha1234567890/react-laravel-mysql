import { configureStore } from '@reduxjs/toolkit';
import { setupListeners } from '@reduxjs/toolkit/query';
import { studentsApi } from './services/students/studentsApi';
import { batchesApi } from './services/batches/batchesApi';
import { coursesApi } from './services/courses/coursesApi';
import taReducer from './features/taModule/taSlice';
import taSchedulingReducer from './features/taModule/taScheduling';
import taAvailabilityReducer from './features/taModule/taAvialability';
import coachTemplateReducer from './features/CoachModule/CoachTemplateSlice';
import coachReducer from './features/CoachModule/coachSlice';
const store = configureStore({

    reducer: {
        taModule: taReducer,
        taAvailability : taAvailabilityReducer,
        taScheduling : taSchedulingReducer,
        taAvialability : taAvailabilityReducer,
        coachTemplate : coachTemplateReducer,
        coachModule : coachReducer,
        [studentsApi.reducerPath]: studentsApi.reducer,
        [batchesApi.reducerPath]: batchesApi.reducer,
        [coursesApi.reducerPath]: coursesApi.reducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat(studentsApi.middleware).concat(batchesApi.middleware).concat(coursesApi.middleware),
});

setupListeners(store.dispatch);

export default store;