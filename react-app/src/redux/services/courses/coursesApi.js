import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { baseUrl } from "../../../utils/baseURL";

export const coursesApi = createApi({
    reducerPath : 'coursesApi',
    baseQuery : fetchBaseQuery({ baseUrl }),
    endpoints : (builder) => ({
        getCourses : builder.query({
            query : (id) => `/courses`,
        }),
    })
})

export const  { useGetCoursesQuery } = coursesApi;