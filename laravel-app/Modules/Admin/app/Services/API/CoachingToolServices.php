<?php

namespace Modules\Admin\Services\API;
use Modules\Admin\Models\AdminUsers;
use Modules\Admin\Models\CoachingTools;
class CoachingToolServices
{
    /**
         * Retrieve all Coaching Tools and return as API response.
         *
         * @return array
         */
        public function getCoachingTools()
        {
            // Retrieve all Coaching Tools from the database
            $tools = CoachingTools::where('is_active', true)->get();
            // print_r($tools);
            // die;
            // Convert the collection to array for easier manipulation
            $tools = $tools->toArray();

            // Check if tools were found
            if ($tools) {
                // Return success response with tools data
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.tools.tool_retrieve'),
                    'data' => $tools,
                ];
            } else {
                // Return failure response if no tools were found
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.tools.tool_not_found'),
                ];
            }
        }

        /**
         * Deletes a Tools .
         *
         * @param int $id The ID of the Tools to delete.
         * @return array An array containing the status, message, and data.
         */
        public function DeleteCoachingTool($id)
        {
            // Find the tool with the given ID
            $tools = CoachingTools::find($id);

            if($tools){
                // Delete the tool
                // $tools_deleted = $tools->delete();
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.tools.tool_deleted'),
                    'data'=>[],//$tools_deleted,
                ];

            }else{  
                return [
                    'status'=>false,
                    'message' =>  __('Admin::response_message.tools.tool_not_found_ID'),
                   
                ];
            }
        }

        /**
         * Deletes a tool.
         *
         * @param int $id The ID of the tool to delete.
         * @return array An array containing the status, message, and data.
         */
        public function UpdateCoachingTools($request,$id)
        {
            // Find the tool with the given ID
            $record = CoachingTools::find($id);

            if($record){
                $record->update($request->all());
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.tools.tool_deleted'),
                    'data'=>$record,
                ];

            }else{  
                return [
                    'status'=>false,
                    'message' =>  __('Admin::response_message.tools.tool_not_found_ID'),
                   
                ];
            }
        }



         /**
         * Store tools based on the provided request data.
         *
         * @param Illuminate\Http\Request $request
         * @return array
         */
        public function storeCoachingTools($request)
        {
            // Extract request parameters
            $name = $request->name;
            
            $newtools = new CoachingTools([
                    'name' => $name,
                    'created_by' => null,
                    'updated_by' => null,
                ]);
                $newtools->save();
                

            if($newtools){
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.tools.tool_store'),
                    'data'=>$newtools,
                ];
            }else{
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.tools.store_tool_failed'),
                ];
            }

        }
}
