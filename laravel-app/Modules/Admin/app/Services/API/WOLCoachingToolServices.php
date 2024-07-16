<?php

namespace Modules\Admin\Services\API;

use Modules\Admin\Models\CoachingTools;
use Modules\Admin\Models\WOLCoachingToolsData;
use Modules\Admin\Models\WOLCategory;
use Modules\Admin\Models\WOLLifeInstruction;
use Modules\Admin\Models\WOLOptionConfig;
use Modules\Admin\Models\WOLOptionConfigScaleWise;
use Modules\Admin\Models\WOLQuestion;
use Modules\Admin\Models\WOLQuestionAnswer;
use Modules\Admin\Models\WOLTestConfig;
use Modules\Admin\Models\WOLTestCategory;
use Modules\Admin\Models\WOLTestConfigWithQuestion;
use Modules\Admin\Models\WOLStudentmapping;


class WOLCoachingToolServices
{

    /**
     * Store a new coaching tool.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the data to create a new coaching tool.
     * 
     * @return array An array containing the status, message, and the newly created coaching tool data if successful, or an error message if the operation fails.
     */
    // public function StoreWOLData($request)
    // {
    //     // Extract name and is_active values from the request
    //     $name = $request->name;
    //     $coaching_tool_id = $request->coaching_tool_id;
    
    //     // Create a new coaching tool using the extracted values
    //     $store_wol_data = WOLCoachingToolsData::create([
    //         'name'=>$name,
    //         'coaching_tool_id'=>$coaching_tool_id,
    //     ]);
    //     // Check if the coaching tool was successfully created
    //     if($store_wol_data){
    //         return [
    //             'status'=>true,
    //             'message' => __('Admin::response_message.wol_tools.wol_data'),
    //             'data'=>$store_wol_data,
    //         ];
    //     }else{
    //         return [
    //         'status'=>false,
    //         'message' => __('Admin::response_message.wol_tools.wol_data_failed'),
    //         ];
    //     }
            
    // }

    // public function GetWOLData()
    // {
   
    //     // get a  coaching tool data using the extracted values
    //     $store_wol_data = WOLCoachingToolsData::where('is_active', true)
    //         ->get();
    //     // Check if the coaching tool was successfully created
    //     if($store_wol_data){
    //         return [
    //             'status'=>true,
    //             'message' => __('Admin::response_message.wol_tools.wol_data_retrieve'),
    //             'data'=>$store_wol_data,
    //         ];
    //     }else{
    //         return [
    //         'status'=>false,
    //         'message' => __('Admin::response_message.wol_tools.wol_data_not_found'),
    //         ];
    //     }
            
    // }
    public function StoreWOLCategory($request)
    {
        // Extract name and is_active values from the request
        $name = $request->name;
        print_r($name);
        // die;
        // Create a new coaching tool using the extracted values
        $store_wol_category = WOLCategory::create([
            'name'=>$name,
        ]);
        // print_r($store_wol_category );
        // die;
        // Check if the coaching tool was successfully created
        if($store_wol_category){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_category'),
                'data'=>$store_wol_category,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_category_failed'),
            ];
        }
            
    }
    public function StatusWOLCategory($id)
    {
            $status_wol_category = WOLCategory ::find($id);
            if (!$status_wol_category) {
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.wol_tools.wol_category_not_found_ID'),
                    ];
            }
            $status_wol_category->is_active = !$status_wol_category->is_active;
            $status_wol_category->save();
            // Check if the coaching tool was successfully created
            if($status_wol_category){
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.wol_tools.wol_category_active'),
                    'data'=>$status_wol_category,
                ];
            }else{
                return [
                'status'=>false,
                'message' => __('Admin::response_message.wol_tools.wol_category_inactive'),
                ];
            }
            
    }
    public function GetWOLCategory()
    {
          // Create a new coaching tool using the extracted values
        $store_wol_category = WOLCategory::all();

        // Check if the coaching tool was successfully created
        if($store_wol_category){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_category_retrieve'),
                'data'=>$store_wol_category,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_category_not_found'),
            ];
        }
             
    }
    public function UpdateWOLCategory($request,$id)
    {

        $name = $request->name;
        // Create a new coaching tool using the extracted values
        $update_wol_category = WOLCategory::find($id);

        // Check if the coaching tool was successfully created
        if($update_wol_category){
            $update_wol_category->name=$name;
            $update_wol_category->save();

            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_category_update'),
                'data'=>$update_wol_category,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_category_not_found_ID'),
            ];
        }
            
    }

    public function StoreWOLLifeInstruction($request)
    {
        // Extract message from the request
        $message = $request->message;

        // Check if there is already a record in the WOLLifeInstruction table
        $existingRecord = WOLLifeInstruction::first();

        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'message' => $message,
            ]);

            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_life_instruction_updated'),
                'data' => $existingRecord,
            ];
        } else {
            // Create a new record
            $store_wol_lifeInstruction = WOLLifeInstruction::create([
                'message' => $message,
            ]);

            if ($store_wol_lifeInstruction) {
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.wol_tools.wol_life_instruction_created'),
                    'data' => $store_wol_lifeInstruction,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.wol_tools.wol_life_instruction_failed'),
                ];
            }
        }

    }

    public function UpdateWOLLifeInstruction($request)
    {

        $message = $request->message;

        // Check if there is already a record in the WOLLifeInstruction table
        $existingRecord = WOLLifeInstruction::first();
    
        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'message' => $message,
            ]);
    
            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_life_instruction_updated'),
                'data' => $existingRecord,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.wol_tools.wol_life_instruction_not_found'),
            ];
        }
        
            
    }
    
    public function GetWOLLifeInstruction()
    {
          // Create a new coaching tool using the extracted values
        $get_wol_lifeInstruction = WOLLifeInstruction::where('is_active', true)->get();

        // Check if the coaching tool was successfully created
        if($get_wol_lifeInstruction){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_life_instruction_retrieve'),
                'data'=>$get_wol_lifeInstruction,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_life_instruction_not_found'),
            ];
        }
            
    }
    
    public function StoreWOLQuestion($request)
    {
        // Extract name and is_active values from the request
        $question = $request->question;
        $wol_category_id = $request->wol_category_id;

    
        // Create a new coaching tool using the extracted values
        $store_wol_question = WOLQuestion::create([
            'question'=>$question,
            'wol_category_id'=>$wol_category_id,
        ]);
        if($store_wol_question){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_question'),
                'data'=>$store_wol_question,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_question_failed'),
            ];
        }
            
    }

    public function StatusWOLQuestion($id)
    {
            $status_wol_question = WOLCoachingToolsQuestion ::find($id);
            if (!$status_wol_question) {
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.wol_tools.wol_category_not_found_ID'),
                    ];
            }
            $status_wol_question->is_active = !$status_wol_question->is_active;
            $status_wol_question->save();
            // Check if the coaching tool was successfully created
            if($status_wol_question){
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.wol_tools.wol_question_active'),
                    'data'=>$status_wol_question,
                ];
            }else{
                return [
                'status'=>false,
                'message' => __('Admin::response_message.wol_tools.wol_question_inactive'),
                ];
            }
            
    }

    public function GetWOLQuestion()
    {
          // Create a new coaching tool using the extracted values
        $get_wol_question = WOLQuestion::all();

        // Check if the coaching tool was successfully created
        if($get_wol_question){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_question_retrieve'),
                'data'=>$get_wol_question,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_question_not_found'),
            ];
        }
            
    }

    public function UpdateWOLQuestion($request,$id)
    {

        $question = $request->question;
        $wol_category_id = $request->wol_category_id;
        // Create a new coaching tool using the extracted values
        $update_wol_question = WOLQuestion::find($id);

        // Check if the coaching tool was successfully created
        if($update_wol_question){
            $update_wol_question->question=$question;
            $update_wol_question->wol_category_id=$wol_category_id;
            $update_wol_question->save();

            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_question_update'),
                'data'=>$update_wol_question,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_question_not_found_ID'),
            ];
        }
    }

    public function StoreWOLOptionConfig($request)
    {
        // Extract message from the request
        $minimum_scale = $request->minimum_scale;
        $maximum_scale = $request->maximum_scale;
        $details=$request->details;

        // Check if there is already a record in the WOLLifeInstruction table
        $existingRecord = WOLOptionConfig::first();

        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'minimum_scale' => $minimum_scale,
                'maximum_scale' => $maximum_scale,
            ]);
            WOLOptionConfigScaleWise::where('wol_option_id', $existingRecord->id)->delete();
            foreach ($details as $detail) {
                WOLOptionConfigScaleWise::create([
                    'wol_option_id' => $existingRecord->id,
                    'point' => $detail['point'],
                    'text' => $detail['text'],
                    'icon' => $detail['icon'],
                ]);
            }

            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_option_config_update'),
                'data' => $existingRecord,
            ];
        } else {
            // Create a new record
            $store_wol_option_config = WOLOptionConfig::create([
                'minimum_scale' => $minimum_scale,
                'maximum_scale' => $maximum_scale,
            ]);

            if ($store_wol_option_config) {
                foreach ($details as $detail) {
                    WOLOptionConfigScaleWise::create([
                        'wol_option_id' => $store_wol_option_config->id,
                        'point' => $detail['point'],
                        'text' => $detail['text'],
                        'icon' => $detail['icon'],
                    ]);
                }
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.wol_tools.wol_option_config'),
                    'data' => $store_wol_option_config,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.wol_tools.wol_option_config_failed'),
                ];
            }
        }

    }

    public function UpdateWOLOptionConfig($request)
    {

        $minimum_scale = $request->minimum_scale;
        $maximum_scale = $request->maximum_scale;
        $details=$request->details;

        // Check if there is already a record in the WOLOptionConfig table
        $existingRecord = WOLOptionConfig::first();
    
        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'minimum_scale' => $minimum_scale,
                'maximum_scale' => $maximum_scale,
            ]);
            WOLOptionConfigScaleWise::where('wol_option_id', $existingRecord->id)->delete();
            foreach ($details as $detail) {
                WOLOptionConfigScaleWise::create([
                    'wol_option_id' => $existingRecord->id,
                    'point' => $detail['point'],
                    'text' => $detail['text'],
                    'icon' => $detail['icon'],
                ]);
            }
            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_option_config_update'),
                'data' => $existingRecord,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.wol_tools.wol_option_config_not_found'),
            ];
        }
        
            
    }
    
    public function GetWOLOptionConfig()
    {
          // Create a new coaching tool using the extracted values
        $get_wol_option_config = WOLOptionConfig::where('is_active', true)
        ->with('GetConfigDetails')
        ->get();

        // Check if the coaching tool was successfully created
        if($get_wol_option_config){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_option_config_retrieve'),
                'data'=>$get_wol_option_config,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_option_config_not_found'),
            ];
        }
    }

    public function StoreWOLConfigTestQuestion($request)
    {
        // Extract message from the request
        $number_of_categories=$request->number_of_categories;
        $categories=$request->categories;
        // Check if there is already a record in the WOLLifeInstruction table
        $existingRecord = WOLTestConfigWithQuestion::first();

        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'number_of_categories' => $number_of_categories,
            ]);
            WOLTestCategory::where('wol_test_config_id', $existingRecord->id)->delete();
            foreach ($categories as $category) {
                WOLTestCategory::create([
                    'wol_test_config_id' => $existingRecord->id,
                    'wol_category_id' => $category['wol_category_id'],
                    'number_of_questions' => $category['number_of_questions'],
                ]);
            }

            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_option_config_update'),
                'data' => $existingRecord,
            ];
        } else {
            // Create a new record
            $store_wol_test_config = WOLTestConfig::create([
                'number_of_categories' => $number_of_categories,
            ]);

            foreach ($categories as $category) {
                WOLTestCategory::create([
                    'wol_test_config_id' => $store_wol_test_config->id,
                    'wol_category_id' => $category['wol_category_id'],
                    'number_of_questions' => $category['number_of_questions'],
                ]);
            }

            if ($store_wol_test_config) {
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.wol_tools.wol_test_config'),
                    'data' => $store_wol_test_config,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.wol_tools.wol_test_config_failed'),
                ];
            }
        }

    }

    public function UpdateWOLConfigTestQuestion($request)
    {

        $number_of_categories=$request->number_of_categories;
        $categories=$request->categories;

        // Check if there is already a record in the WOLOptionConfig table
        $existingRecord = WOLTestConfigWithQuestion::first();
    
        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'number_of_categories' => $number_of_categories,
            ]);
            WOLTestCategory::where('wol_test_config_id', $existingRecord->id)->delete();
            foreach ($categories as $category) {
                WOLTestCategory::create([
                    'wol_test_config_id' => $existingRecord->id,
                    'wol_category_id' => $category['wol_category_id'],
                    'number_of_questions' => $category['number_of_questions'],
                ]);
            }
            return [
                'status' => true,
                'message' => __('Admin::response_message.wol_tools.wol_test_config_update'),
                'data' => $existingRecord,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.wol_tools.wol_test_config_not_found'),
            ];
        }
        
            
    }
    
    public function GetWOLConfigTestQuestion()
    {
          // Create a new coaching tool using the extracted values
        $get_wol_test_config = WOLTestConfigWithQuestion::where('is_active', true)
        ->get();

        

        // Check if the coaching tool was successfully created
        if($get_wol_test_config){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.wol_tools.wol_test_config_retrieve'),
                'data'=>$get_wol_test_config,
            ];
        }else{
            return [
            'status'=>false,
            'message' => __('Admin::response_message.wol_tools.wol_test_config_not_found'),
            ];
        }
    }
}
