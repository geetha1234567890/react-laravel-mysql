import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { baseUrl } from "../../../utils/baseURL";

export const batchesApi = createApi({
    reducerPath : 'batchesApi',
    baseQuery : fetchBaseQuery({ baseUrl }),
    endpoints : (builder) => ({
        getBatches : builder.query({
            query : () => `/admin/batches`,
        })
    })
})

export const  { useGetBatchesQuery } = batchesApi;
