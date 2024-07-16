<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Admin\Models\AdminUsers;
use Modules\Admin\Models\TACoachSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Modules\Admin\Services\API\TACoachSlotsServices;
use Modules\Admin\Http\Requests\StoreTACoachSlotsRequest;
use Modules\Admin\Helpers\APIResponse\APIResponseHelper;

class TACoachSlotsController extends Controller
{

    private $ta_coach_slots_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\TACoachSlotsServices $ta_coach_slots_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        TACoachSlotsServices $ta_coach_slots_services,
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
        $this->ta_coach_slots_services = $ta_coach_slots_services;
        $this->api_response_helper = $api_response_helper;
    }

    /**
     * Retrieve all TA coach slots and return as API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function index()
    // {   
    
    //     try {
    //         // Retrieve all TA coach slots using the service class method
    //         $get_slots = $this->ta_coach_slots_services->getSlots();

    //         // Generate API response based on the retrieved slots
    //         return $this->api_response_helper::generateAPIResponse(
    //             $get_slots,
    //             $this->status_code,
    //             $this->not_found_status_code 
    //         );
    //     } catch (\Exception $e) {
    //         // Handle any exceptions that occur during the execution
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'An error occurred while processing the request.',
    //             'error' => $e->getMessage(), // Optionally include the error message for debugging
    //         ],   $this->server_error,); // You can adjust the status code based on the type of error encountered
    //     }
    // }
    
    /**
     * Handle the request to get TA coach slots for a specific admin user within a date range.
     *
     * @param \App\Http\Requests\StoreTACoachSlotsRequest $request The request object containing the necessary parameters.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the slots data or an error message.
     */
    public function getTACoachRecords(Request $request)
    {   
        try {
            // Retrieve all TA coach slots using the service class method
            $get_slots = $this->ta_coach_slots_services->getSlotsForSpecificUser($request);

            // Generate API response based on the retrieved slots
            return $this->api_response_helper::generateAPIResponse(
                $get_slots,
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

    public function getTACoachSlotForDate(Request $request)
    {   
        try {
            // Retrieve all TA coach slots using the service class method
            $get_slots = $this->ta_coach_slots_services->getSlotsForSpecificDate($request);

            // Generate API response based on the retrieved slots
            return $this->api_response_helper::generateAPIResponse(
                $get_slots,
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
     * Store a new TA coach slot based on the incoming request.
     *
     * @param \Modules\Admin\Http\Requests\StoreTACoachSlotsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTACoachSlotsRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            
            // Store slots using the service class method
            $store_slots = $this->ta_coach_slots_services->storeSlots($request);

            // Generate API response based on the result of storing slots
            return $this->api_response_helper::generateAPIResponse(
                $store_slots,
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
     * Deletes a slot with the given ID.
     *
     * @param int $id The ID of the slot to delete.
     * @return \Illuminate\Http\JsonResponse The API response indicating success or failure.
     */
    public function destroy($id)
    {
        try {
            // Attempt to delete the slot using the ta_coach_slots_services
            $delete_slot = $this->ta_coach_slots_services->DeleteSlot($id);

            // Generate and return the API response based on the result of the delete operation
            return $this->api_response_helper::generateAPIResponse(
                $delete_slot,
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

    // Other methods ...

