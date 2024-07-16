<?php

namespace Modules\Admin\Services\API;

use Carbon\Carbon;
use Vimeo\Vimeo;
use Illuminate\Support\Facades\Storage;
use Auth;

use Modules\Admin\Models\CoachingTemplate;
use Modules\Admin\Models\CoachingTemplateModule;
use Modules\Admin\Models\CoachingTemplateModuleActivity;
use Modules\Admin\Models\CoachingTemplateActivityType;
use Modules\Admin\Models\CoachTemModActPrerequisites;
use Modules\Admin\Models\CoachingTemplateAssignment;
use Modules\Admin\Models\CoachingToolsAssignment;
use Modules\Admin\Models\CoachingTools;
use Modules\Admin\Models\APIKey;



class CoachingTemplateServices
{

    /**
     * Store coaching template data based on the incoming request.
     *
     * @param \Illuminate\Http\Request $request The request object containing input data.
     * @return array Array containing status, message, and data of the stored coaching template.
     */
    public function storeCoachingTempateData($request)
    {
        // Retrieve input data from the request
        $name = $request->name;
        $duration = $request->duration;
        $is_active = $request->is_active;
        
        // Attempt to create a new CoachingTemplate record
        $store_coaching_template = CoachingTemplate::create([
            'name'=>$name,
            'duration'=>$duration,
            'is_active'=>$is_active,
        ]);

        // Check if creation was successful
        if($store_coaching_template){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.store_coaching_template'),
                'data'=>$store_coaching_template,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.coaching_template_failed'),
            ];
        }
            
    }


    /**
     * Stores module data for a coaching template.
     *
     * This function creates a new module record in the CoachingTemplateModule table using
     * the provided request data. The module data includes the template ID, module name, 
     * activation status, and the IDs of the user who created and updated the module.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing module data.
     *
     * @return array An array containing the status of the operation, a message, and the created
     *               module data if successful.
     */
    public function storeModuleData($request)
    {
        // Retrieve input data from the request
        $template_id = $request->template_id;
        $module_name = $request->module_name;
        $is_active = $request->is_active;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;
        
        // Attempt to create a new tempalte module record
        $store_module = CoachingTemplateModule::create([
            'template_id' => $template_id,
            'module_name' => $module_name,
            'is_active' => $is_active,
            'created_by' => $created_by,
            'updated_by' => $updated_by,
        ]);

        if($store_module){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.store_module'),
                'data'=>$store_module,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.module_failed'),
            ];
        }
            
    }

    /**
     * Updates module data for a coaching template.
     *
     * This function updates an existing module record in the CoachingTemplateModule table 
     * using the provided request data. The module data includes the module ID, template ID, 
     * module name, activation status, and the IDs of the user who created and updated the module.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing module data.
     *
     * @return array An array containing the status of the operation, a message, and the updated
     *               module data if successful.
     */
    public function updateModuleData($request)
    {
        // Retrieve input data from the request
        $module_id = $request->module_id;
        $template_id = $request->template_id;
        $module_name = $request->module_name;
        $is_active = $request->is_active;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;
        
        // Find the module by its ID
        $find_module = CoachingTemplateModule::find($module_id);

        if($find_module){
            // Attempt to update the module record
            $update_module = $find_module->update([
                'template_id' => $template_id,
                'module_name' => $module_name,
                'is_active' => $is_active,
                'created_by' => $created_by,
                'updated_by' => $updated_by,
            ]);

            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.update_module'),
                'data'=>$update_module,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.module_failed_update'),
            ];
        }
            
    }

    /**
     * Retrieves all coaching templates along with their modules.
     *
     * This function fetches all coaching templates from the database, including their associated 
     * modules. It returns an appropriate response based on whether the templates were successfully 
     * retrieved or not.
     *
     * @return array An array containing the status of the operation, a message, and the retrieved 
     *               template data if successful, or an error message if no templates are found.
     */
    public function getAllTemplatesData()
    {
        // Retrieve all templates with their associated modules
        $templates = CoachingTemplate::with(['modules','modules.activities','modules.activities.activityType'])->get();

        if($templates){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.showing_template'),
                'data'=>$templates,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.template_not_found'),
            ];
        }
            
    }

    
    /**
     * Retrieves all coaching template modules along with their associated templates.
     *
     * This function fetches all coaching template modules from the database, including their 
     * associated templates. It returns an appropriate response based on whether the modules 
     * were successfully retrieved or not.
     *
     * @return array An array containing the status of the operation, a message, and the retrieved 
     *               module data if successful, or an error message if no modules are found.
     */
    public function getTemplateModulesData()
    {
        // Retrieve all modules with their associated templates
        $get_module = CoachingTemplateModule::with('template','activities','activities.activityType')->get();

        if($get_module){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.showing_template_module'),
                'data'=>$get_module,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.template_module_not_found'),
            ];
        }
            
    }

    /**
     * Store activity data for a coaching template module.
     *
     * This method receives a request object, extracts the necessary data, and stores
     * a new activity in the database. The activity details include module ID, activity type ID,
     * activity name, due date, points, and other relevant fields.
     *
     * @param \Illuminate\Http\Request $request The request object containing activity data.
     * @return array An array containing the status, message, and stored activity data if successful.
     */
    public function storeActivityData($request)
    {
        // Extract data from the request object
        $module_id = $request->module_id;
        $activity_type_id = $request->activity_type_id;
        $activity_name = $request->activity_name;
        $due_date = Carbon::parse($request->due_date)->toDateString();
        $points = $request->points;
        $after_due_date = Carbon::parse($request->after_due_date)->toDateString();
        $is_active = $request->is_active;

        // Get the authenticated user
        $admin = Auth::user();
        $created_by = $admin ? $admin->id : $request->created_by;
        $updated_by = $admin ? $admin->id : $request->updated_by;

        // Create a new activity record
        $store_module_activity = CoachingTemplateModuleActivity::create([
            'module_id' => $module_id,
            'activity_type_id' => $activity_type_id,
            'activity_name' => $activity_name,
            'due_date' => $due_date,
            'points' => $points,
            'after_due_date' => $after_due_date,
            'is_active' => $is_active,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        // Return the result
        if($store_module_activity){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.store_activity'),
                'data'=>$store_module_activity,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.activity_failed'),
            ];
        }
            
    }

     /**
     * Update activity data for a coaching template module.
     *
     * This method receives a request object, extracts the necessary data, and updates
     * an existing activity in the database. The activity details include module ID,
     * activity type ID, activity name, due date, points, and other relevant fields.
     *
     * @param \Illuminate\Http\Request $request The request object containing activity data.
     * @return array An array containing the status, message, and updated activity data if successful.
     */
    public function updateActivityData($request)
    {
        // Extract data from the request object
        $activity_id = $request->activity_id;
        $module_id = $request->module_id;
        $activity_type_id = $request->activity_type_id;
        $activity_name = $request->activity_name;
        $due_date = $request->due_date;
        $points = $request->points;
        $after_due_date = $request->after_due_date;
        $is_active = $request->is_active;

        // Get the authenticated user
        $admin = Auth::user();
        $updated_by = $admin ? $admin->id : $request->updated_by;

        // Find the activity by its ID
        $activity = CoachingTemplateModuleActivity::find($activity_id);

        if ($activity) {
            // Update the activity record
            $activity->update([
                'module_id' => $module_id,
                'activity_type_id' => $activity_type_id,
                'activity_name' => $activity_name,
                'due_date' => $due_date,
                'points' => $points,
                'after_due_date' => $after_due_date,
                'is_active' => $is_active,
                'updated_by' => $updated_by
            ]);

            return [
                'status' => true,
                'message' => __('Admin::response_message.coaching_template.update_activity'),
                'data' => $activity,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.coaching_template.activity_not_found'),
            ];
        }
    }


    /**
     * Retrieve all activity types.
     *
     * This function fetches all the activity types from the CoachingTemplateActivityType model.
     * It returns a response indicating whether the retrieval was successful or not.
     *
     * @return array An array containing the status, message, and data (if any).
     */
    public function getActivityTypeData()
    {
        // Fetch all activity types
        $activity_type = CoachingTemplateActivityType::all();

        // Check if activity types are found
        if($activity_type){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.showing_activity_type'),
                'data'=>$activity_type,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.activity_type_not_found'),
            ];
        }
    }

    
    /**
     * Update the status of a coaching template module activity.
     *
     * This function updates the 'is_active' status of a coaching template module activity
     * based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing 'activity_id'
     *                                          and 'status' parameters.
     * @return array Array containing status of the operation, a message, and optionally,
     *               the updated activity object on success.
     */
    public function activityStatusUpdate($request)
    {
        // Extract activity_id and status from the request
        $activity_id = $request->activity_id;
        $status = $request->status;

        // Find the coaching template module activity by activity_id
        $activity = CoachingTemplateModuleActivity::find($activity_id);
   
        if ($activity) {
            // If activity found, update the 'is_active' status
            $activity->update([
                'is_active' => $status,
            ]);

            return [
                'status' => true,
                'message' => __('Admin::response_message.coaching_template.activity_status'),
                'data' => $activity,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.coaching_template.activity_not_found'),
            ];
        }
    }

    
    /**
    * Store Activity Prerequisite 
    * This function stores a new activity prerequisite in the database.
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return  \Illuminate\Http\JsonResponse
    * 
    * @throws  \Illuminate\Validation\ValidationException
    */
    public function storeActivityPrerequisite($request)
    {
        $module_id = $request->module_id;
        $activity_id = $request->activity_id;
        $template_id = $request->template_id;
        $lock_until_date = Carbon::parse($request->lock_until_date)->toDateString();
        $time = $request->time;
        $is_locked = $request->is_locked;
        $is_active = $request->is_active;

        // Get the authenticated user
        $admin = Auth::user();
        $created_by = $admin ? $admin->id : $request->created_by;
        $updated_by = $admin ? $admin->id : $request->updated_by;

        // Create a new activity record
        $store_module_activity = CoachTemModActPrerequisites::create([
            'module_id' => $module_id,
            'activity_id' => $activity_id,
            'template_id' => $template_id,
            'lock_until_date' => $lock_until_date,
            'time' => $time,
            'is_locked' => $is_locked,
            'is_active' => $is_active,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        // Return the result
        if($store_module_activity){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.store_activity'),
                'data'=>$store_module_activity,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.activity_failed'),
            ];
        }
            
    }

    /**
     * Handle the linking of an activity with a video or PDF file.
     *
     * This method processes the request to link an activity with an uploaded file or a provided URL.
     * It supports both video and PDF file uploads, storing videos on Vimeo and PDFs locally. 
     * If a direct URL is provided, it will use that instead of uploading a file.
     *
     * @param \Illuminate\Http\Request $request The request object containing activity details and file data.
     * @return array An array containing the status, message, and updated activity data if successful.
     */
    public function linkActivityData($request)
    {
        $activity_id = $request->activity_id;
        $activity_type_id = $request->activity_type_id;

        // Initialize activity URL
        $activity_url = null;

        // Handle file upload if 'data' is present in the request
        if ($request->hasFile('activity_files')) {
            $file = $request->file('activity_files');

            // Check if the file is a video or PDF
            if (in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'avi'])) {
                // Upload to Vimeo if it's a video
                $activity_url = $this->uploadToVimeo($file);
            } elseif ($file->getClientOriginalExtension() === 'pdf') {
                // Store locally if it's a PDF
                $activity_url = $this->storePdfFile($file);
            }
        }

        // Check if a link is provided in the request
        $activity_link = $request->link;
        if($activity_link){
            $activity_url = $activity_link;
        }

        // Update or retrieve the activity record based on activity_id
        $link_activity = CoachingTemplateModuleActivity::find($activity_id);

        // Fetch activity type name based on activity_type_id
        $type_name = CoachingTemplateActivityType::find($activity_type_id)->type_name;

        if($type_name=='Wheel of Life'){

            // Fetch and organize assigned templates for student and batch types
            $templates_assinged = CoachingTemplateModuleActivity::with(['module','module.template','module.template.coachingTemplateAssignment'])->find($activity_id)->toArray();
            
            $template_assigned_student_batch_ids = [];
            foreach($templates_assinged['module']['template']['coaching_template_assignment'] as $template_assinged){
                if($template_assinged['assignable_type'] == 'student' || $template_assinged['assignable_type'] == 'batch'){
                    $template_assigned_student_batch_ids[$template_assinged['assignable_type']] = $template_assinged['assignable_id'];
                }              
            }

            // Fetch the coaching tool ID based on type name 'Wheel of Life'
            $coaching_id = CoachingTools::where('name', $type_name)->value('id');
         
            // Assign coaching tools to students and batches
            foreach($template_assigned_student_batch_ids as $key=>$value){
                // Check if the assignment already exists
                $existing_assignment = CoachingToolsAssignment::where('coaching_tool_id', $coaching_id)
                ->where('activity_id', $activity_id)
                ->where('assignable_id', $value)
                ->where('assignable_type', $key)
                ->exists();

                if (!$existing_assignment) {
                    CoachingToolsAssignment::create([
                        'coaching_tool_id'=>$coaching_id,
                        'activity_id'=>$activity_id,
                        'assignable_id'=>$value,
                        'assignable_type'=>$key
                    ]);
                }
            }
        }
    
        // Update the activity record with the provided activity type ID and URL
        if($link_activity){

               $link_activity = $link_activity->update([
                    'activity_type_id' => $activity_type_id,
                    'activity_url' => $activity_url
                ]) ;

            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.link_activity'),
                'data'=>$link_activity,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.link_activity_failed'),
            ];
        }
            
    }   


    /**
     * Assigns a template to an entity (Student, Batch, or Coach) and prevents duplicate assignments.
     *
     * @param \Illuminate\Http\Request $request The request object containing template_id, assignable_id, and assignable_type.
     * @return array An array containing the status, message, and optionally the data of the created assignment.
     */
    public function templateAssignData($request)
    {
        $template_id = $request->template_id; // template Id
        $assignable_id = $request->assignable_id; // 'Student', 'Batch' or coach id
        $assignable_type = $request->assignable_type; // 'Student', 'Batch' or coach

        // Check if the record already exists
        $existing_assignment = CoachingTemplateAssignment::where('template_id', $template_id)
        ->where('assignable_id', $assignable_id)
        ->where('assignable_type', $assignable_type)
        ->first();

        if ($existing_assignment) {
            return [
                'status' => false,
                'message' => __('Admin::response_message.coaching_template.already_assigned', ['assignable_type' => $assignable_type]),
            ];
        }

        // Create the new assignment
        $coaching_template_assignment = CoachingTemplateAssignment::create([
            'template_id'=>$template_id,
            'assignable_id'=>$assignable_id,
            'assignable_type' => $assignable_type
        ]);

        // Return the result
        if($coaching_template_assignment){

            return [
                'status'=>true,
                'message' => __('Admin::response_message.coaching_template.template_assigned'),
                'data'=>$coaching_template_assignment,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.coaching_template.template_assigned_failed'),
            ];
        }
    }


    /**
     * Store a PDF file locally and return its URL.
     *
     * This method takes an uploaded PDF file, stores it in the 'public/pdf_files' directory
     * with a unique name based on the current timestamp, and then generates a URL for accessing
     * the stored file.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded PDF file.
     * @return string The URL of the stored PDF file.
     */
    private function storePdfFile($file)
    {
        // Store the PDF file locally
        $file_name = time() . '.' . $file->getClientOriginalExtension();
        $file_path = $file->storeAs('public/pdf_files', $file_name);

        // Generate the URL for the stored file
        $file_url = Storage::url($file_path);

        return $file_url;
    }


    /**
     * Upload a file to Vimeo and return the video URL.
     *
     * @param \Illuminate\Http\UploadedFile $file The file to be uploaded.
     * @return string The URL of the uploaded video on Vimeo.
     */
    private function uploadToVimeo($file)
    {
        // Your Vimeo API credentials
        $client_id = env('VIMEO_CLIENT_ID');
        $client_secret = env('VIMEO_CLIENT_SECRET');
        $access_token = env('VIMEO_ACCESS_TOKEN');

        // Initialize Vimeo client
        $vimeo = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);

        // Upload the video file to Vimeo
        $uri = $vimeo->upload($file->getPathname(), [
            'name' => $file->getClientOriginalName(),
            'description' => 'Uploaded via API'
        ]);

        // Extract video ID from the URI
        $video_id = str_replace('/videos/', '', $uri);

        // Return the video URL
        return 'https://vimeo.com/' . $video_id;
    }


    /**
     * Generate a unique API key and handle database insertion/update.
     *
     * This function generates a unique API key and ensures that only one record exists
     * in the database. If the API key record already exists, it updates the existing record.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object (not currently used).
     * @return array Array containing the status of the operation, a message, and the API key data.
     */
    public function generateUniqueApiKey($request)
    {
        // Generate a random string using random_bytes() for added security
        $random_bytes = random_bytes(32); // 32 bytes = 256 bits
        
        // Convert the random bytes to a hexadecimal string
        $api_key = bin2hex($random_bytes);

        // Check if an API key record already exists
        $existing_api_key = APIKey::first();

        if ($existing_api_key) {
            // If record exists, update the existing API key
            $existing_api_key->update([
                'key' => $api_key,
            ]);

            // Return success response with updated API key data
            return [
                'status' => true,
                'message' => __('Admin::response_message.coaching_template.api_key_updated'),
                'data' => $existing_api_key,
            ];
        } else {
            // If no record exists, create a new API key record
            $new_api_key = APIKey::create([
                'key' => $api_key,
            ]);

            // Return success response with newly created API key data
            return [
                'status' => true,
                'message' => __('Admin::response_message.coaching_template.api_key_generated'),
                'data' => $new_api_key,
            ];
        }
    }


}
