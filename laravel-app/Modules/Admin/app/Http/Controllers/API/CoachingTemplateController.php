<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Admin\Services\API\CoachingTemplateServices;
use Modules\Admin\Http\Requests\StoreCoachingTemplateRequest;
use Modules\Admin\Http\Requests\StoreCoachingTemplateModuleRequest;
use Modules\Admin\Http\Requests\StoreModuleActivityRequest;
use Modules\Admin\Http\Requests\StoreActivityPrerequisiteRequest;
use Modules\Admin\Http\Requests\LinkActivityRequest;

// use Modules\Admin\App\Models\CoachingTemplateModule; 
use Modules\Admin\Models\CoachingTemplate;
use Modules\Admin\Models\CoachingTemplateModule;
use Modules\Admin\Helpers\APIResponse\APIResponseHelper;

class CoachingTemplateController extends Controller
{
    private $coaching_template_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\CoachingTemplateServices $coaching_template_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        CoachingTemplateServices $coaching_template_services,
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
        $this->coaching_template_services = $coaching_template_services;
        $this->api_response_helper = $api_response_helper;
    }

        /**
     * Store a coaching template based on validated data from the request.
     *
     * @param \App\Http\Requests\StoreCoachingTemplateRequest $request The validated request object.
     * @return \Illuminate\Http\JsonResponse JSON response containing the API result.
     */
    public function storeTemplate(StoreCoachingTemplateRequest $request)
    {
        try {
            // Validate the incoming request using StoreCoachingTemplateRequest rules
            $validatedData = $request->validated();
            
            // Call the service method to store the coaching template data
            $store_template = $this->coaching_template_services->storeCoachingTempateData($request);
            
            // Generate an API response using a helper method
            return $this->api_response_helper::generateAPIResponse(
                $store_template,
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
     * Retrieves all coaching templates.
     *
     * This function handles the HTTP request to retrieve all coaching templates. It attempts 
     * to fetch the templates using the `getAllTemplatesData` service and returns an appropriate 
     * API response. If an exception occurs during the process, it catches the exception and 
     * returns an error response.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the status of the operation and the retrieved template data if successful, or an error message if an exception occurs.
     */
    public function getAllTemplates()
    {
        try {
            
            // Attempt to retrieve all templates using the service
            $get_template = $this->coaching_template_services->getAllTemplatesData();
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $get_template,
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
     * Stores a new coaching template module.
     *
     * This function handles the HTTP request to store a new coaching template module. It validates 
     * the request data, attempts to store the module using the `storeModuleData` service, and 
     * returns an appropriate API response. If an exception occurs during the process, it catches 
     * the exception and returns an error response.
     *
     * @param \App\Http\Requests\StoreCoachingTemplateModuleRequest $request The HTTP request object containing validated module data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the status of the operation and the stored module data if successful, or an error message if an exception occurs.
     */
    public function storeModule(StoreCoachingTemplateModuleRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            
            // Attempt to store the module using the service
            $store_template_module = $this->coaching_template_services->storeModuleData($request);
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $store_template_module,
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
     * Retrieves all coaching template modules.
     *
     * This function handles the HTTP request to retrieve all coaching template modules. It attempts 
     * to fetch the modules using the `getTemplateModulesData` service and returns an appropriate 
     * API response. If an exception occurs during the process, it catches the exception and 
     * returns an error response.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the status of the operation and the retrieved module data if successful, or an error message if an exception occurs.
     */
    public function getTemplateModules()
    {
        try {
            // Attempt to retrieve all template modules using the service
            $get_template_modules = $this->coaching_template_services->getTemplateModulesData();
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $get_template_modules,
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
     * Updates a coaching template module.
     *
     * This function handles the HTTP request to update a coaching template module. It validates 
     * the request data, attempts to update the module using the `updateModuleData` service, and 
     * returns an appropriate API response. If an exception occurs during the process, it catches 
     * the exception and returns an error response.
     *
     * @param \App\Http\Requests\StoreCoachingTemplateModuleRequest $request The HTTP request object containing validated module data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the status of the operation and the updated module data if successful, or an error message if an exception occurs.
     */
    public function updateModule(StoreCoachingTemplateModuleRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            
            // Attempt to update the module using the service
            $update_template_module = $this->coaching_template_services->updateModuleData($request);
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $update_template_module,
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
     * Store activity data for a coaching template module.
     *
     * This method handles a request to store activity data by invoking the `storeActivityData`
     * method from the `coaching_template_services` service. It generates an API response
     * based on the result of the operation. If an exception occurs, it catches the exception
     * and returns an error response.
     *
     * @param \Illuminate\Http\Request $request The request object containing activity data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function storeActivity(StoreModuleActivityRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            
            $store_activity = $this->coaching_template_services->storeActivityData($request);
            
            return $this->api_response_helper::generateAPIResponse(
                $store_activity,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }

     /**
     * Update activity data for a coaching template module.
     *
     * This method handles a request to update activity data by invoking the `updateActivityData`
     * method from the `coaching_template_services` service. It generates an API response
     * based on the result of the operation. If an exception occurs, it catches the exception
     * and returns an error response.
     *
     * @param \Illuminate\Http\Request $request The request object containing activity data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function updateActivity(StoreModuleActivityRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            
            $update_activity = $this->coaching_template_services->updateActivityData($request);
            
            return $this->api_response_helper::generateAPIResponse(
                $update_activity,
                $this->status_code,
                $this->not_found_status_code 
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }

    /**
     * Get and return all activity types.
     *
     * This function calls the `getActivityTypeData` method from the coaching template services 
     * to fetch all activity types. It then generates and returns an API response. 
     * If an exception occurs, it catches the exception and returns an error response.
     *
     * @return \Illuminate\Http\JsonResponse The API response containing the status, message, and data or error message.
     */
    public function getActivityType()
    {
        try {
             // Retrieve activity type data from the coaching template services
            $get_activity_type = $this->coaching_template_services->getActivityTypeData();
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $get_activity_type,
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
     * Update activity status based on the request.
     *
     * This function handles the request to update the activity status using
     * the coaching template services. It catches any exceptions that may occur
     * during the process and returns appropriate JSON responses.
     *
     * @param Request $request The HTTP request object containing the data for
     *                         updating the activity status.
     * @return \Illuminate\Http\JsonResponse JSON response containing the result of
     *                                       the activity status update.
     */
    public function activityStatus(Request $request)
    {
        try {
            // Update activity status using the coaching template services
            $activity_status = $this->coaching_template_services->activityStatusUpdate($request);
            
            // Generate and return the API response
            return $this->api_response_helper::generateAPIResponse(
                $activity_status,
                $this->status_code,
                $this->not_found_status_code 
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }
    
    /**
    * Store Activity Prerequisite
    * 
    * This function stores a new activity prerequisite in the database.
    * It uses the StoreActivityPrerequisiteRequest request object to validate the input data.
    * If the validation succeeds, it calls the storeActivityPrerequisite method on the coaching_template_services object to store the activity prerequisite.
    * If an exception occurs during processing, it returns a JSON response with an error message and a 500 status code.
    * 
    * @param  StoreActivityPrerequisiteRequest  $request
    * @return  \Illuminate\Http\JsonResponse
    * 
    * @throws  \Illuminate\Validation\ValidationException
    * @throws  \Exception
    */
    public function activityPrerequisite(StoreActivityPrerequisiteRequest $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            
            $store_activity_prerequisite = $this->coaching_template_services->storeActivityPrerequisite($request);
            
            return $this->api_response_helper::generateAPIResponse(
                $store_activity_prerequisite,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }


    /**
     * Handle the linking of activity based on the given request.
     *
     * @param LinkActivityRequest $request The incoming request containing the data to link the activity.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the result of the operation.
     */
    public function linkActivity(LinkActivityRequest $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();
            
            // Process the link activity using the coaching template services
            $store_link_activity = $this->coaching_template_services->linkActivityData($request);
            
            // Generate and return an API response
            return $this->api_response_helper::generateAPIResponse(
                $store_link_activity,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions by returning an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }

    /**
     * Handles the request to assign a template to an entity (Student, Batch, or Coach).
     *
     * @param \Illuminate\Http\Request $request The request object containing the data for the template assignment.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function templateAssign(Request $request)
    {
        try {
            // Call the service method to assign the template            
            $tempalte_assigned = $this->coaching_template_services->templateAssignData($request);
            
            return $this->api_response_helper::generateAPIResponse(
                $tempalte_assigned,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions by returning an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }


    /**
     * Generate a new API key and handle API response.
     *
     * This function calls a service method to generate a unique API key based on
     * the provided request. It catches any exceptions that may occur during the
     * key generation process and returns appropriate JSON responses.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing any necessary data.
     * @return \Illuminate\Http\JsonResponse JSON response containing the result of the API key generation.
     */
    public function generateApiKey(Request $request)
    {
        try {
            // Call the service method to assign the template            
            $tempalte_assigned = $this->coaching_template_services->generateUniqueApiKey($request);
            
            return $this->api_response_helper::generateAPIResponse(
                $tempalte_assigned,
                $this->new_resource_create,
                $this->unprocessable_entity_status_code 
            );
        } catch (\Exception $e) {
            // Handle any exceptions by returning an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], $this->server_error);
        }
    }
    
    
}
