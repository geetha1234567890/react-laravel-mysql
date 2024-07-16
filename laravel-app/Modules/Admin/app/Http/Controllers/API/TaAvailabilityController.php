<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Modules\Admin\Models\TACoachAvailability;
use Modules\Admin\Models\AdminUsers;
use Auth;



use Modules\Admin\Services\API\TaAvailabilityServices;
use Modules\Admin\Helpers\APIResponse\APIResponseHelper;

class TaAvailabilityController extends Controller
{

    private $ta_availability_services;
    private $api_response_helper;

    /**
     * Constructor method for initializing dependencies and status codes.
     *
     * @param \Modules\Admin\Services\API\TaAvailabilityServices $ta_availability_services
     * @param \Modules\Admin\Helpers\APIResponse\APIResponseHelper $api_response_helper
     */
    public function __construct(
        TaAvailabilityServices $ta_availability_services,
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
        $this->ta_availability_services = $ta_availability_services;
        $this->api_response_helper = $api_response_helper;
    }


    /**
     * Handle the request to get today's available (TA).
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the available TA data or an error message.
     */
    public function index()
    {
        try {
            // Fetch the available (TA) for today using the TaAvailabilityServices
            $get_ta_available = $this->ta_availability_services->getTaAvailable();

            // Generate and return the API response using the response helper
            return $this->api_response_helper::generateAPIResponse(
                $get_ta_available,
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }


    /**
     * Create a new Teaching Assistant (TA) availability record.
     *
     * This method creates a new TA availability record based on the provided data.
     *
     * @param \Illuminate\Http\Request $request
     *   The HTTP request object containing the new TA availability data.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response indicating the outcome of the creation operation.
     *
     * @throws \Illuminate\Validation\ValidationException
     *   If the validation of the request data fails.
     * @throws \Exception
     *   If any unexpected error occurs during the operation.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data.
            $validator = Validator::make($request->all(), [
                'admin_user_id' => 'required|integer',
                'current_availability' => 'required|string|max:255',
                'calendar' => 'required|string|max:255',
                'is_active' => 'required|boolean',
                'created_by' => 'required|integer',
                'updated_by' => 'nullable|integer',
            ]);

            // Check if validation fails.
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Retrieve the admin user associated with the provided admin_user_id.
            $admin_user_id = $request->admin_user_id ?? null;
            $TA = AdminUsers::find($admin_user_id);
            $ta_id = $TA->id ?? null;

            // Retrieve the currently authenticated admin user or use the created_by value from the request.
            $admin = Auth::user();
            $admin_id = $admin->id ?? $request->created_by;
            $admin = AdminUsers::find($admin_id);
            $admin_id = $admin->id ?? null;

            // Check if both TA and admin users exist.
            if ($ta_id && $admin_id) {
                // Create the TA availability record.
                $ta = TaAvailability::create([
                    'admin_user_id' => $ta_id,
                    'current_availability' => $request->current_availability,
                    'calendar' => $request->calendar,
                    'is_active' => $request->is_active,
                    'created_by' => $admin_id,
                    'updated_by' => $request->updated_by,
                ]);

                // Return a successful response.
                return response()->json([
                    'message' => 'TA Availability created successfully',
                    'ta' => $ta,
                ], 201);

            } else {
                // Return an error response if TA or admin user not found.
                return response()->json([
                    'message' => 'User Not found!',
                ], 400);
            }
           
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation error and return a 422 response.
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any unexpected error and return a 500 response.
            Log::error('Error creating TA availability:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Retrieve a specific Teaching Assistant (TA) availability record.
     *
     * This method fetches a TA availability record along with its associated admin user,
     * creator, and updater details based on the provided ID.
     *
     * @param int $id
     *   The ID of the TA availability record to retrieve.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response containing the retrieved TA availability record or an error message.
     *
     * @throws \Illuminate\Database\QueryException
     *   If an error occurs during the retrieval operation.
     */
    public function show($id)
    {
        try {
            // Retrieve the TA availability record with related admin user, creator, and updater details.
            $retrieve_ta = TaAvailability::with(['adminUser','createdBy','updatedBy'])->find($id);

            // Return the retrieved TA availability record.
            return response()->json($retrieve_ta);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve TA availability', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update a Teaching Assistant (TA) availability record.
     *
     * This method updates the 'current_availability' status and other details of a TA based on the provided ID.
     *
     * @param \Illuminate\Http\Request $request
     *   The HTTP request object containing the updated TA availability data.
     * @param int $id
     *   The ID of the TA availability record to update.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response indicating the outcome of the update operation.
     *
     * @throws \Illuminate\Validation\ValidationException
     *   If the validation of the request data fails.
     * @throws \Exception
     *   If any unexpected error occurs during the operation.
     */
    public function update(Request $request, $id)
    {
        try {
            
            // Validate the request data.
            $validator = Validator::make($request->all(), [
                'admin_user_id' => 'required|integer',
                'current_availability' => 'required|string|max:255',
                'calendar' => 'required|string|max:255',
                'is_active' => 'required|boolean',
                'created_by' => 'required|integer',
                'updated_by' => 'nullable|integer',
            ]);

            // Check if validation fails.
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Find the TA availability record by ID.
            $find_ta = TaAvailability::find($id);
            if(!$find_ta){
                return response()->json(['error' => 'Ta Availability not found on this ID'], 400);
            }

            // Retrieve the admin user associated with the provided admin_user_id.
            $admin_user_id = $request->admin_user_id ?? null;
            $TA = AdminUsers::find($admin_user_id);
            $ta_id = $TA->id ?? null;

            // Retrieve the currently authenticated admin user or use the created_by value from the request.
            $admin = Auth::user();
            $admin_id = $admin->id ?? $request->created_by;
            $admin = AdminUsers::find($admin_id);
            $admin_id = $admin->id ?? null;

            // Check if both TA and admin users exist.
            if ($ta_id && $admin_id) {
                // Prepare data for updating the TA availability record.
                $data = [
                    'admin_user_id' => $ta_id,
                    'current_availability' => $request->current_availability,
                    'calendar' => $request->calendar,
                    'is_active' => $request->is_active,
                    'created_by' => $admin_id,
                    'updated_by' => $request->updated_by,
                ];

                // Update the TA availability record.
                $ta_updated = $find_ta->update($data);

                // Return a successful response.
                return response()->json([
                    'message' => 'TA Availability Updated successfully',
                    'ta' => $ta_updated,
                ], 201);

            } else {
                // Return an error response if TA or admin user not found.
                return response()->json([
                    'message' => 'User Not found!',
                ], 400);
            }
           
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation error and return a 422 response.
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any unexpected error and return a 500 response.
            Log::error('Error updating TA availability:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Delete a Teaching Assistant (TA) availability record.
     *
     * This method deletes a TA availability record based on the provided ID.
     *
     * @param int $id
     *   The ID of the TA availability record to delete.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response indicating the outcome of the delete operation.
     *
     * @throws \Illuminate\Database\QueryException
     *   If an error occurs during the delete operation.
     */
    public function destroy($id)
    {
        try {
            // Find the TA availability record by ID.
            $find_ta = TaAvailability::find($id);

            // Check if the TA availability record exists.
            if(!$find_ta){
                return response()->json(['error' => 'Ta Availability not found on this ID'], 400);
            }

            // Delete the TA availability record
            $find_ta->delete();
            // Optionally, you can force delete the record by using the following line:
            // $find_ta->forceDelete();

            // Return a successful response.
            return response()->json("Record deleted successfully", 200);
        } catch (QueryException $e) {
            // Return an error response if a query exception occurs.
            return response()->json(['message' => 'Failed to delete Ta Availability', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Change the availability status of a Teaching Assistant (TA).
     *
     * This method updates the 'current_availability' status of a TA based on the provided ID.
     *
     * @param \Illuminate\Http\Request $request
     *   The HTTP request object containing the 'current_availability' field.
     * @param int $ta_availability_id
     *   The ID of the TA availability record to update.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response containing the outcome of the update operation.
     *
     * @throws \Illuminate\Validation\ValidationException
     *   If the validation of the request data fails.
     * @throws \Exception
     *   If any unexpected error occurs during the operation.
     */
    public function changeAvailabilityStatus(Request $request, $ta_availability_id)
    {
        try {
            // Validate the request data.
            $validator = Validator::make($request->all(), [
                'current_availability' => 'required|string|max:255',
            ]);

            // Check if validation fails.
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Find the TA availability record by ID.
            $find_ta = TaAvailability::find($ta_availability_id);
            if(!$find_ta){
                return response()->json(['error' => 'Ta Availability not found on this ID'], 400);
            }   

            // Prepare data for updating the TA availability status.
            $data = [
                'current_availability' => $request->current_availability,
            ];

            // Update the TA availability status.
            $ta_updated = $find_ta->update($data);

            // Return a successful response.
            return response()->json([
                'message' => 'TA Availability Status Updated successfully',
                'ta' => $ta_updated,
            ], 201);

           
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation error and return a 422 response.
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Log any unexpected error and return a 500 response.
            Log::error('Error updating TA availability:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }

    }
}
