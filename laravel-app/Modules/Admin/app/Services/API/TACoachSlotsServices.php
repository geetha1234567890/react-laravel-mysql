<?php 
    namespace Modules\Admin\Services\API;

    use Modules\Admin\Models\AdminUsers;
    use Modules\Admin\Models\TACoachSlots;
    use Carbon\Carbon;


    // TODO : Delete slot api modification

    class TACoachSlotsServices
    {

        /**
         * Retrieve all TA coach slots and return as API response.
         *
         * @return array
         */
        // public function getSlots()
        // {
        //     // Retrieve all TA coach slots from the database
        //     $slots = TACoachSlots::all();

        //     // Convert the collection to array for easier manipulation
        //     $slots = $slots->toArray();

        //     // Check if slots were found
        //     if ($slots) {
        //         // Return success response with slots data
        //         return [
        //             'status' => true,
        //             'message' => __('Admin::response_message.slots.slot_retrieve'),
        //             'data' => $slots,
        //         ];
        //     } else {
        //         // Return failure response if no slots were found
        //         return [
        //             'status' => false,
        //             'message' => __('Admin::response_message.slots.slot_not_found'),
        //         ];
        //     }
        // }

        /**
         * Retrieve TA coach slots for a specific admin user within a date range.
         *
         * @param \Illuminate\Http\Request $request The request object containing admin_user_id, start_date, and end_date.
         * @return array The response containing status, message, and data if slots are found.
         */
        public function getSlotsForSpecificUser($request)
        {

            // Retrieve the admin user ID from the request
            $admin_user_id = $request->admin_user_id;

            // Parse the start date and end date from the request
            $start_date = Carbon::parse($request->start_date)->toDateString();
            $end_date = Carbon::parse($request->end_date)->toDateString();

            $slots = TACoachSlots::where('admin_user_id', $admin_user_id)
            ->whereBetween('slot_date', [$start_date, $end_date]) // Check if slot_date is between start_date and end_date
            ->orderBy('slot_date')                                // Order the results by slot_date in ascending order
            ->get(); 

            // Convert the collection to array for easier manipulation
            $slots = $slots->toArray();

            // Check if slots were found
            if ($slots) {
                // Return success response with slots data
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.slots.slot_retrieve'),
                    'data' => $slots,
                ];
            } else {
                // Return failure response if no slots were found
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.slots.slot_not_found'),
                ];
            }
        }

        public function getSlotsForSpecificDate($request)
        {
            // Retrieve the admin user ID from the request
            $admin_user_id = $request->admin_user_id;
            $date = Carbon::parse($request->date);

            // if ($date->isBefore(Carbon::today())) {
            //     return [
            //         'status'=>false,
            //         'message' => __('Admin::response_message.schedule.schedule_start_date'),
            //     ];
            // }

            $slots = TACoachSlots::where('admin_user_id', $admin_user_id)
            ->where('slot_date',$date)
            ->orderBy('from_time')                               
            ->get(); 

            // Convert the collection to array for easier manipulation
            $slots = $slots->toArray();
            // Check if slots were found
            if ($slots) {
                // Return success response with slots data
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.slots.slot_retrieve'),
                    'data' => $slots,
                ];
            } else {
                // Return failure response if no slots were found
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.slots.slot_not_found'),
                ];
            }
        }

        /**
         * Deletes a slot and all related slots in the series.
         *
         * @param int $id The ID of the slot to delete.
         * @return array An array containing the status, message, and data.
         */
        
        public function DeleteSlot($id)
        {
            // Find the slot with the given ID
            $slot = TACoachSlots::find($id); 

            if($slot){
                // Delete the slot
                $slot_deleted = $slot->delete();

                // Delete all slots with the same series ID as the deleted slot
                $related_slots_deleted = TACoachSlots::where('series', $slot->id)->delete();

                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.slots.slot_deleted'),
                    'data'=>$slot_deleted,
                ];

            }else{  
                return [
                    'status'=>false,
                    'message' =>  __('Admin::response_message.slots.slot_not_found_ID'),
                   
                ];
            }
        }


        /**
         * Store slots based on the provided request data.
         *
         * @param Illuminate\Http\Request $request
         * @return array
         */
        public function storeSlots($request)
        {
            // Extract request parameters
            $adminUserId = $request->admin_user_id;
            $slotDate = Carbon::parse($request->slot_date);
            $fromTime = $request->from_time;
            $toTime = $request->to_time;
            $endDate = Carbon::parse($request->end_date);
            $weeks = $request->weeks ?? []; // array example: [1,0,0,1,0,1,0]
        
            // Validate slotDate against today's date
            if ($slotDate->isBefore(Carbon::today())) {
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.slots.slot_start_date'),
                ];
            }

            $potentialDates = [];
        
            // Calculate all dates within the range based on the weeks array
            for ($date = $slotDate; $date->lte($endDate); $date->addDay()) {
                $dayOfWeek = $date->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
                if (isset($weeks[$dayOfWeek]) && $weeks[$dayOfWeek] == 1) {
                    $potentialDates[] = $date->format('Y-m-d');
                }
            }
        
            // Check for slot clashes on all potential dates
            foreach ($potentialDates as $date) {
                $existingSlots = TACoachSlots::where('admin_user_id', $adminUserId)
                                            ->where('slot_date', $date)
                                            ->orderBy('from_time')
                                            ->get();
        
                foreach ($existingSlots as $slot) {
                    if (($fromTime >= $slot->from_time && $fromTime < $slot->to_time) ||
                        ($toTime > $slot->from_time && $toTime <= $slot->to_time) ||
                        ($fromTime <= $slot->from_time && $toTime >= $slot->to_time)) {

                        return [
                            'status'=>false,
                            'message' => __('Admin::response_message.slots.slot_clash_message', ['date' => $date]),
                        ];

                    }
                }
            }
        
            // No clashes found, proceed to create slots
            $created_slots = [];
            $seriesId = null;
        
            foreach ($potentialDates as $date) {
                $newSlot = new TACoachSlots([
                    'admin_user_id' => $adminUserId,
                    'slot_date' => $date,
                    'from_time' => $fromTime,
                    'to_time' => $toTime,
                    'timezone' => $request->timezone,
                    'created_by' => $request->created_by,
                    'updated_by' => $request->updated_by,
                ]);
                
                $newSlot->save();
        
                // Assign series ID for grouping, ensuring null for the first slot and parent ID for subsequent slots
                if ($seriesId === null) {
                    // If $seriesId is null, set it to the ID of the first created slot
                    $seriesId = $newSlot->id;
                } else {
                    // For subsequent slots, assign the same $seriesId (parent ID)
                    $newSlot->series = $seriesId;
                    $newSlot->save();
                }
        
                $created_slots[] = $newSlot;
            }

            // Return appropriate response based on slot creation result
            if($created_slots){
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.slots.slot_store'),
                    'data'=>$created_slots,
                ];
            }else{
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.slots.store_slot_failed'),
                ];
            }

        }

    }
?>