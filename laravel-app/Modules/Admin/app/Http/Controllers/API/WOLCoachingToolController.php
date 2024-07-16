<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Admin\Services\API\WOLCoachingToolServices;

use Modules\Admin\Http\Requests\StoreWOLDataRequest;
use Modules\Admin\Http\Requests\StoreWOLCategoryRequest;
use Modules\Admin\Http\Requests\UpdateWOLCategoryRequest;
use Modules\Admin\Http\Requests\StoreWOLLifeInstructionRequest;
use Modules\Admin\Http\Requests\StoreWOLQuestionRequest;
use Modules\Admin\Http\Requests\UpdateWOLQuestionRequest;
use Modules\Admin\Http\Requests\StoreWOLOptionConfigRequest;
use Modules\Admin\Http\Requests\StoreWOLTestConfigRequest;
use Modules\Admin\Http\Requests\UpdateWOLTestConfigRequest;

use Modules\Admin\Helpers\APIResponse\APIResponseHelper;

class WOLCoachingToolController extends Controller
{

    private $wol_coaching_tool_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\WOLCoachingToolServices $wol_coaching_tool_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        WOLCoachingToolServices $wol_coaching_tool_services,
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
        $this->wol_coaching_tool_services = $wol_coaching_tool_services;
        $this->api_response_helper = $api_response_helper;
    }

    /**
     * Store a new WOL coaching tool.
     *
     * @param \Modules\Admin\Http\Requests\StoreWOLCoachingToolRequest $request The incoming request containing the data to create a new coaching tool.
     * 
     * @return \Illuminate\Http\JsonResponse The response containing the status, message, and data of the created coaching tool, or an error message if the operation fails.
     */
    public function store_WOLData(StoreWOLDataRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->StoreWOLData($request);

         
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

    public function get_WOLData()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLData();

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
    public function store_WOLCategory(StoreWOLCategoryRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->StoreWOLCategory($request);

         
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

    public function get_WOLCategory()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLCategory();

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
    public function update_StatusWOLCategory($id)
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->StatusWOLCategory($id);

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

    public function update_WOLCategory(UpdateWOLCategoryRequest $request,$id)
    {
        try {
            $validatedData = $request->validated();
            // Update WOL Category using the service class method
            $get_schedules = $this->wol_coaching_tool_services->UpdateWOLCategory($request,$id);

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

    public function store_WOLLifeInstruction(StoreWOLLifeInstructionRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->StoreWOLLifeInstruction($request);

         
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
    public function update_WOLLifeInstruction(StoreWOLLifeInstructionRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->UpdateWOLLifeInstruction($request,$id);

         
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
    public function get_WOLLifeInstruction()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLLifeInstruction();

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

    public function store_WOLQuestion(StoreWOLQuestionRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->StoreWOLQuestion($request);
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
    public function get_WOLQuestion()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLQuestion();

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
    public function update_StatusWOLQuestion($id)
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->StatusWOLQuestion($id);

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

    public function update_WOLQuestion(UpdateWOLQuestionRequest $request,$id)
    {
        try {
            $validatedData = $request->validated();
            // Update WOL Category using the service class method
            $get_schedules = $this->wol_coaching_tool_services->UpdateWOLQuestion($request,$id);

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

    public function store_WOLOptionQuestionAnswer(StoreWOLCoachingToolRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->StoreWOLOptionQuestionAnswer($request);
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
    public function store_WOLOptionConfig(StoreWOLOptionConfigRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_optionconfig = $this->wol_coaching_tool_services->StoreWOLOptionConfig($request);

         
            return $this->api_response_helper::generateAPIResponse(
                $store_optionconfig,
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
    public function update_WOLOptionConfig(StoreWOLOptionConfigRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->UpdateWOLOptionConfig($request);

         
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
    public function get_WOLOptionConfig()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLOptionConfig();

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

    public function store_WOLTestConfig(StoreWOLTestConfigRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_optionconfig = $this->wol_coaching_tool_services->StoreWOLTestConfig($request);

         
            return $this->api_response_helper::generateAPIResponse(
                $store_optionconfig,
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
    public function update_WOLTestConfig(UpdateWOLTestConfigRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->UpdateWOLTestConfig($request);

         
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
    public function get_WOLTestConfig()
    {
 
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLTestConfig();

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

    public function store_WOLConfigTestQuestion(StoreWOLTestConfigQuestionRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_optionconfig = $this->wol_coaching_tool_services->StoreWOLConfigTestQuestion($request);

         
            return $this->api_response_helper::generateAPIResponse(
                $store_optionconfig,
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

    public function update_WOLConfigTestQuestion(UpdateWOLTestConfigQuestionRequest $request)
    {
        try { 
            // Validate the request data
            $validatedData = $request->validated();
           
            // Call the service to store the coaching tool
            $store_schedule = $this->wol_coaching_tool_services->UpdateWOLConfigTestQuestion($request);

         
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

    public function get_WOLConfigTestQuestion()
    {
        try {
            // Retrieve all TA coach schedules using the service class method
            $get_schedules = $this->wol_coaching_tool_services->GetWOLConfigTestQuestion();

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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
