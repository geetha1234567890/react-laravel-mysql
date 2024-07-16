<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Modules\Admin\Models\AdminUsers;
use Modules\Admin\Models\CoachScheduling;
use Modules\Admin\Models\TACoachStudentMapping;
use Modules\Admin\Models\TACoachBatchMapping;
use Modules\Admin\Models\Student;
use Modules\Admin\Models\Batch;

use Modules\Admin\Models\TACoachScheduling;
use Modules\Admin\Models\TACoachBatchScheduling;
use Modules\Admin\Models\TACoachStudentScheduling;


use Modules\Admin\Services\API\CoachSchedulingServices;
use Modules\Admin\Http\Requests\StoreTACoachScheduleRequest;
use Modules\Admin\Http\Requests\GetCoachSchedulesRecordsRequest;
use Modules\Admin\Helpers\APIResponse\APIResponseHelper;

class CoachSchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $ta_coach_schedule_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\CoachSchedulingServices $ta_coach_schedule_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        CoachSchedulingServices $ta_coach_schedule_services,
        APIResponseHelper $api_response_helper,
    ){
        // Initialize HTTP status codes for various responses
        $this->status_code = config('global_constant.STATUS_CODE.SUCCESS');
        $this->not_found_status_code = config('global_constant.STATUS_CODE.NOT_FOUND');
        $this->bad_request_status_code = config('global_constant.STATUS_CODE.BAD_REQUEST');
        $this->credentials_valid_status_code = config('global_constant.STATUS_CODE.CREDENTIALS_VALID');
        $this->no_content_status_code = config('global_constant.STATUS_CODE.NO_CONTENT');
        $this->unprocessable_entity_status_code =  config('global_constant.STATUS_CODE.UNPROCESSABLE_ENTITY');
        $this->new_resource_create =  config('global_constant.STATUS_CODE.NEW_RESOURCE_CREATE');
        $this->server_error = config('global_constant.STATUS_CODE.SERVER_ERROR');

        // Injected dependencies initialization
        $this->ta_coach_schedule_services = $ta_coach_schedule_services;
        $this->api_response_helper = $api_response_helper;
    }

    public function getActiveBatchesForATA($Coach_Id)
    {
        try {

            $mappings = TACoachBatchMapping::with(['batch'])
                        ->where('admin_users_id',   $Coach_Id)
                        ->where('is_active', true)
                        ->where('is_deleted', false)
                        ->get();

        $data = $mappings->map(function($mapping) {
            return [
                'id' => $mapping->id,
                'batch' => [
                    'id' => $mapping->batch->id,
                    'name' => $mapping->batch->name,
                ],
            ];
        });

        } catch (\Exception $e) {
            Log::error('Error fetching Active Batches:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve Batches'], 500);
        }
    }

    public function getActiveStudentsForATA($Coach_Id)
    {
        try {

            $mappings  = TACoachStudentMapping::with(['Student'])
                        ->where('Admin_Users_ID',   $Coach_Id)
                        ->where('is_active', true)
                        ->where('is_deleted', false)
                        ->get();
        $data = $mappings->map(function($mapping) {
            return [
                'id' => $mapping->id,
                'student' => [
                    'id' => $mapping->student->id,
                    'name' => $mapping->student->name,
                ],
            ];
        });

        } catch (\Exception $e) {
            Log::error('Error fetching Active student with Coach id: ',$Coach_Id, ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve Students with Coach'], 500);
        }
    }

    public function index()
    {
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->ta_coach_schedule_services->getSchedules();

            // Generate API response based on the retrieved schedules
            return $this->api_response_helper::generateAPIResponse(
                $get_schedules,
                $this->status_code,
                $this->not_found_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
    }

    public function getOneCoachRecords(Request $request,$Coach_id)
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->ta_coach_schedule_services->getOneCoachAllRecords($request,$Coach_id);

            // Generate API response based on the retrieved schedules
            return $this->api_response_helper::generateAPIResponse(
                $get_schedules,
                $this->status_code,
                $this->not_found_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
    }

   /**
     * Store a new TA coach schedule based on the incoming request.
     *
     * @param \Modules\Admin\Http\Requests\StoreTACoachScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTACoachScheduleRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            
            // Store schedules using the service class method
           
            $store_schedule = $this->ta_coach_schedule_services->storeSchedules($request);

            // Generate API response based on the result of storing schedules
            return $this->api_response_helper::generateAPIResponse(
                $store_schedule,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'admin_user_id' => 'required|integer',
                'schedule_date' => 'required|date',
                'slot_id' => 'required|integer',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s',
                'timezone' => 'required|string',
                'event_status' => 'required|string'
            ]);
            
            // Store schedules using the service class method
            $update_schedule = $this->ta_coach_schedule_services->UpdateSchedules($request);

            // Generate API response based on the result of storing schedules
            return $this->api_response_helper::generateAPIResponse(
                $update_schedule,
                $this->status_code,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
        
    }

    public function destroy($id)
    {
        try {
            // Attempt to delete the schedule using the ta_coach_schedules_services
            $delete_schedule = $this->ta_coach_schedules_services->DeleteSchedules($id);

            // Generate and return the API response based on the result of the delete operation
            return $this->api_response_helper::generateAPIResponse(
                $delete_schedule,
                $this->no_content_status_code,
                $this->not_found_status_code 
            );

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
    }

    public function cancel($id)
    {
        try {
            // Attempt to delete the schedule using the ta_coach_schedules_services
            $delete_schedule = $this->ta_coach_schedules_services->CancelSchedules($id);

            // Generate and return the API response based on the result of the delete operation
            return $this->api_response_helper::generateAPIResponse(
                $delete_schedule,
                $this->no_content_status_code,
                $this->not_found_status_code 
            );

        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }
    }


    /**
     * Retrieve scheduled records based on validated request data.
     *
     * @param App\Http\Requests\GetCoachSchedulesRecordsRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function getScheduledRecords(GetCoachSchedulesRecordsRequest $request)
    { 
        try {
            // Validate the incoming request data using the validated method from the request class
            $validatedData = $request->validated();
            
            // Call the service method to retrieve TA schedules records
            $get_schedule_recods = $this->ta_coach_schedule_services->getCoachSchedulesRecords($request);

            // Generate an API response based on the result of retrieving schedules
            return $this->api_response_helper::generateAPIResponse(
                $get_schedule_recods,
                $this->status_code,
                $this->not_found_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(), // Optionally include the error message for debugging
            ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
        }

    }
    
}
