<?php 

    namespace Modules\Admin\Helpers\APIResponse;

    /**
     * Helper class for generating consistent API responses.
     */
    class APIResponseHelper
    {   
         /**
         * Generate a JSON API response based on the provided result and status codes.
         *
         * @param array $result The result of the operation, containing 'status', 'message', and 'data'.
         * @param int $status_code The HTTP status code to be used for successful responses.
         * @param int $invalid_status_code The HTTP status code to be used for unsuccessful responses.
         * @return \Illuminate\Http\JsonResponse JSON response containing 'status', 'status_code', 'message', and 'data'.
         */
        public static function generateAPIResponse($result, $status_code, $invalid_status_code)
        {
            if ($result['status']) {
                return response()->json([
                    'status' => true,
                    'status_code'=>$status_code,
                    'message' => $result['message'],
                    'data' => $result['data']
                ], $status_code);
            } else {
                return response()->json([
                    'status' => false,
                    'status_code'=>$invalid_status_code,
                    'message' => $result['message'],
                    'data' => new \stdClass,
                ], $invalid_status_code);
            }
        }
    }    
?>