<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Modules\Admin\Services\API\CoachingToolServices;
use Modules\Admin\Http\Requests\CoachingToolRequest;
use Modules\Admin\Helpers\APIResponse\APIResponseHelper;


class CoachingToolController extends Controller
{
    private $coaching_tool_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\CoachingToolServices $coaching_tool_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        CoachingToolServices $coaching_tool_services,
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
        $this->coaching_tool_services = $coaching_tool_services;
        $this->api_response_helper = $api_response_helper;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Retrieve all TA coach slots using the service class method
            $get_tools = $this->coaching_tool_services->getCoachingTools();

            // Generate API response based on the retrieved slots
            return $this->api_response_helper::generateAPIResponse(
                $get_tools,
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
     * Store a newly created resource in storage.
     */
    public function store(CoachingToolRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            
            // Store slots using the service class method
            $store_tools = $this->coaching_tool_services->storeCoachingTools($request);

            // Generate API response based on the result of storing slots
            return $this->api_response_helper::generateAPIResponse(
                $store_tools,
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
     */
    public function update(CoachingToolRequest $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            
            // Store schedules using the service class method
            $update_schedule = $this->coaching_tool_services->UpdateCoachingTools($request,$id);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Attempt to delete the slot using the ta_coach_slots_services
            $delete_tools = $this->coaching_tool_services->DeleteCoachingTool($id);

            // Generate and return the API response based on the result of the delete operation
            return $this->api_response_helper::generateAPIResponse(
                $delete_tools,
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
