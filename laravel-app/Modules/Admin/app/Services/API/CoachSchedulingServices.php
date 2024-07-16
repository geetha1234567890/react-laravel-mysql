<?php 
    namespace Modules\Admin\Services\API;

    use Modules\Admin\Models\AdminUsers;
    use Modules\Admin\Models\Role;
    use Modules\Admin\Models\TACoachScheduling;
    use Modules\Admin\Models\TACoachBatchScheduling;
    use Modules\Admin\Models\TACoachStudentScheduling;
    use Modules\Admin\Models\TACoachStudentMapping;
    use Modules\Admin\Models\TACoachBatchMapping;
    use Modules\Admin\Models\StudentBatchMapping; 
    use Carbon\Carbon;
    use Modules\Admin\Models\Student;
    use Modules\Admin\Models\Batch;
    use Modules\Admin\Models\TACoachSlots;

class CoachSchedulingServices
{

    /**
     * Retrieve all TA coach schedules and return as API response.
     *
     * @return array
     */
    public function getSchedules()
    {
        // Get all users with the 'TA' role
        $CoachRole = Role::where('role_name', 'Coach')->first();
    
        if ($CoachRole) {
            $usersWithCoachRole = AdminUsers::whereHas('roles', function ($query) use ($CoachRole) {
                $query->where('role_id', $CoachRole->id);
            })->get();
        
            // Initialize an empty array to collect schedules data
            $schedules_coach_list = [];
        
            foreach ($usersWithCoachRole as $user) {
                $Coach_Id = $user->id;
                $Coach_data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username, // Assuming 'username' field exists in your 'AdminUsers' model
                ];
            
                // Fetch batches mapped to this TA
                $taCoachScheduling = TACoachScheduling::find($Coach_Id);
                $batchCount=0;
                if ($taCoachScheduling) {
                    $batchCount = $taCoachScheduling->scheduleBatch()
                        ->where('is_active', true)
                        ->where('is_deleted', false)
                        ->count();
                }
                
                $studentCount=0;
                // Fetch students mapped to this TA
                if ($taCoachScheduling) {
                    $studentCount = $taCoachScheduling->scheduleStudent()
                        ->where('is_active', true)
                        ->where('is_deleted', false)
                        ->count();
                }
                $schedules[] = [
                    'coach_data' => $Coach_data,
                    'batches' => $batchCount,
                    'students' => $studentCount,
                    ];
            }
        
            // Check if any schedules were found
            if (!empty($schedules)) {
                // Return success response with schedules data
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.schedules.schedule_retrieve'),
                    'data' => $schedules,
                ];
            } else {
                // Return failure response if no schedules were found
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.schedules.schedule_not_found'),
                ];
            }
        } else {
            // Handle case where 'TA' role does not exist
            return [
                'status' => false,
                'message' => __('Admin::response_message.schedules.Coach_role_not_found'),
            ];
        }
    }



    public function getOneCoachAllRecords($request,$Coach_id)
    {   
        $coachRole = Role::where('role_name', 'Coach')->first();
        $coach = AdminUsers::where('id', $Coach_id)
            ->whereHas('roles', function ($query) use ($coachRole) {
                $query->where('role_id', $coachRole->id);
            })
            ->first();

        if (is_null($coach)) {
            return [
                'status' => false,
                'message' => 'Coach Not Found or not a Coach'
            ];
        }
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if(!$startDate &&  !$endDate){
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        }
        
        // Retrieve all TA coach schedules for the week from the database
        $schedules = TACoachScheduling::where('admin_user_id', $Coach_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('is_deleted', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        

        // Check if schedules were found
        if ($schedules) {
            // Return success response with schedules data
            $schedules = $schedules->toArray();
            return [
                'status' => true,
                'message' => __('Admin::response_message.schedules.schedule_retrieve'),
                'data' => $schedules,
            ];
        } else {
            // Return failure response if no schedules were found
            return [
                'status' => false,
                'message' => __('Admin::response_message.schedules.schedule_not_found'),
            ];
        }
    }
    
    /**
     * Deletes a schedule and all related schedules in the series.
     *
     * @param int $id The ID of the schedule to delete.
     * @return array An array containing the status, message, and data.
     */
    public function DeleteSchedules($id)
    {
        // Find the slot with the given ID
        $schedules = TACoachScheduling::find($id);

        if($schedules){
            // Delete the slot
            $schedules_deleted = $schedules->delete();
            //ToDO
            // Delete all schedules with the same series ID as the deleted slot
            $related_schedules_deleted = TACoachScheduling::where('series', $schedules->id)->delete();

            return [
                'status'=>true,
                'message' => __('Admin::response_message.schedule.schedule_deleted'),
                'data'=>$schedules_deleted,
            ];

        }else{  
            return [
                'status'=>false,
                'message' =>  __('Admin::response_message.schedule.schedule_not_found'),
               
            ];
        }
    }

    /**
     * Cancle a schedule and all related schedules in the series.
     *
     * @param int $id The ID of the schedule to delete.
     * @return array An array containing the status, message, and data.
     */
    public function CancelSchedules($id)
    {
        // Find the slot with the given ID
        $schedule = TACoachScheduling::find($id);
    
        if ($schedule) {
            // Update the isDeleted flag to true
            $schedule->isDeleted = true;
            $schedule->event_status = 'cancelled';
            $schedule->is_active = false;
            $schedule_deleted = $schedule->save();
        //ToDO
            // Update the isDeleted flag for all schedules with the same series ID as the deleted slot
            $related_schedules_deleted = TACoachScheduling::where('series', $schedule->series)
                ->update(['isDeleted' => true]);
        
            return [
                'status' => true,
                'message' => __('Admin::response_message.schedule.schedule_deleted'),
                'data' => $schedule_deleted,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.schedule.schedule_not_found'),
            ];
        }
    }

    /**
     * Store schedules based on the provided request data.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function storeSchedules($request)
    {
        // Extract request parameters
        $adminUserId = $request->admin_user_id;
        $meeting_name = $request->meeting_name;
        $meeting_url = $request->meeting_url;
        $start_date = Carbon::parse($request->schedule_date);
        $slot_id = $request->slot_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $timezone = $request->timezone;
        $event_status = $request->event_status;
        $endDate = Carbon::parse($request->end_date);
        $studentIds = $request->studentId ?? []; 
        $batchIds = $request->batchId ?? [];
        $weeks = $request->weeks ?? []; // array example: [1,0,0,1,0,1,0]
    
        // Validate slotDate against today's date
        if ($start_date->isBefore(Carbon::today())) {
            return [
                'status'=>false,
                'message' => __('Admin::response_message.schedule.schedule_start_date'),
            ];
        }

        $potentialDates = [];
        // Calculate all dates within the range based on the weeks array
        for ($date = $start_date; $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
            if (isset($weeks[$dayOfWeek]) && $weeks[$dayOfWeek] == 1) {
                $potentialDates[] = $date->format('Y-m-d');
            }
        }
    
        // Check for slot clashes on all potential dates
        foreach ($potentialDates as $date) {
            $existingSchedule = TACoachScheduling::where('admin_user_id', $adminUserId)
                                        ->where('date', $date)
                                        ->orderBy('start_time')
                                        ->where('is_deleted', false)
                                        ->get();
    
            foreach ($existingSchedule as $schedule) {
                if (($start_time >= $schedule->start_time && $start_time < $schedule->end_time) ||
                    ($end_time > $schedule->start_time && $schedule <= $schedule->end_time) ||
                    ($start_time <= $schedule->start_time && $end_time >= $schedule->end_time)) {

                    return [
                        'status'=>false,
                        'message' => __('Admin::response_message.schedule.schedule_clash_message', ['date' => $date]),
                    ];

                }
            }
        }
        $potentialSlots = [];
        foreach ($potentialDates as $date) {
            $existingSlots = TACoachSlots::where('admin_user_id', $adminUserId)
                                        ->where('slot_date', $date)
                                        ->orderBy('from_time')
                                        ->get();

            if ($existingSlots->isEmpty()) {
                return [
                    'status' => false,
                    'message' => ['not slot on ', ['date' => $date]],
                ];
            }
            $count = 0;
            foreach ($existingSlots as $slot) {
                if (($start_time >= $slot->from_time && $end_time <= $slot->to_time)) {
                    $potentialSlots[] = $slot;
                    $count = 1;
                }
            }
            if($count==0){
                return [
                    'status' => false,
                    'message' => ['time not within slot',[
                        'date' => $date,
                        'slot_from_time' => $start_time,
                        'slot_to_time' => $end_time
                    ]
                    ],
                ];
            }
        }

        $created_schedule = [];
        $seriesId = null;
        
        foreach ($potentialSlots as $slot) {

            $newSchedule = new TACoachScheduling([
                'admin_user_id' => $adminUserId,
                'meeting_name' => $meeting_name,
                'meeting_url' => $meeting_url,
                'date' => $slot['slot_date'],
                'slot_id' => $slot['id'],
                'start_time' => $start_time,
                'end_time' => $end_time,
                'time_zone' => $timezone,
                'event_status' => $event_status,
                'created_by' => null,
                'updated_by' => null
            ]);
            
            $newSchedule->save();
            // Assign series ID for grouping, ensuring null for the first slot and parent ID for subsequent schedules
            if ($seriesId === null) {
                // If $seriesId is null, set it to the ID of the first created slot
                $seriesId = $newSchedule->id;
            } else {
                // For subsequent schedules, assign the same $seriesId (parent ID)
                $newSchedule->series = $seriesId;
                $newSchedule->save();
            }

            foreach ($request->batchId as $batchData) {
                $Batch = Batch::find($batchData);
                $newSchedule->batch()->attach($Batch);
                $studentListData = StudentBatchMapping::where('batch_id',$batchData)->get();
                foreach ($studentListData as $studentData) {
                    $student = Student::find($studentData);
                    $newSchedule->students()->attach($student);
                }
            }

            foreach ($request->studentId as $studentData) {
                $student = Student::find($studentData);
                if (!$newSchedule->students->contains($student)) {
                    $newSchedule->students()->attach($student);
                }
            }

            $created_schedule[] = $newSchedule;
        }

        // Return appropriate response based on slot creation result
        if($created_schedule){
            return [
                'status'=>true,
                'message' => __('Admin::response_message.schedule.schedule_store'),
                'data'=>$created_schedule,
            ];
        }else{
            return [
                'status'=>false,
                'message' => __('Admin::response_message.schedule.store_schedule_failed'),
            ];
        }

    }


    /**
     * Update schedules based on the provided request data.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function UpdateSchedules($request, $id)
    {
        // Extract request parameters
        $adminUserId = $request->admin_user_id;
        $start_date = Carbon::parse($request->schedule_date);
        $slot_id = $request->slot_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $timezone = $request->timezone;
        $event_status = $request->event_status;

        // Validate slotDate against today's date
        if ($start_date->isBefore(Carbon::today())) {
            return [
                'status'=>false,
                'message' => __('Admin::response_message.schedule.schedule_start_date'),
            ];
        }
        $existingSchedule = TACoachScheduling::where('admin_user_id', $adminUserId)
                                        ->where('id', $id)
                                        ->where('is_deleted', false)
                                        ->orderBy('start_time')
                                        ->get();
    
            foreach ($existingSchedule as $schedule) {
                if (($start_time >= $schedule->start_time && $start_time < $schedule->end_time) ||
                    ($end_time > $schedule->start_time && $schedule <= $schedule->end_time) ||
                    ($start_time <= $schedule->start_time && $end_time >= $schedule->end_time)) {

                    return [
                        'status'=>false,
                        'message' => __('Admin::response_message.schedule.schedule_clash_message', ['date' => $date]),
                    ];

                }
            }

        $existingSlot = TACoachSlots::where('admin_user_id', $adminUserId)
                                        ->where('id', $slot_id)
                                        ->where('slot_date', $start_date)
                                        ->get();

        if ($existingSlot->isEmpty()) {
            return [
                'status' => false,
                'message' => ['no slot for this date and time ', ['date' => $start_date]],
            ];
        }
        //die($existingSlot[0]);

        if($existingSlot[0]['from_time'] > $start_time || $existingSlot[0]['to_time'] < $end_time){
            return [
                'status' => false,
                'message' => ['time not within slot',[
                    'date' => $start_date,
                    'slot_from_time' => $start_time,
                    'slot_to_time' => $end_time
                ]
                ],
            ];
        }
           
    
        // No clashes found, proceed to create schedules
        $newSchedule=TACoachScheduling::where('id', $id)->get();

        // Return appropriate response based on slot creation result
        if($newSchedule){
            $newSchedule->start_date =  $start_date;
            $newSchedule->slot_id =  $slot_id;
            $newSchedule->start_time =  $start_time;
            $newSchedule->end_time =  $end_time;
            $newSchedule->timezone =  $timezone;
            $newSchedule->event_status= $event_status;
            $newSchedule->save();
            return [
                'status'=>true,
                'message' => __('Admin::response_message.schedule.schedule_store'),
                'data'=>$newSchedule,
            ];
        }else{
            return [
                'status'=>false,
                'message' => __('Admin::response_message.schedule.store_schedule_failed'),
            ];
        }

    }


    /**
     * Retrieve TA schedules records based on admin user ID and data criteria.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getCoachSchedulesRecords($request)
    {
        // Extract admin user ID and data from request input
        $admin_user_id = $request->input('admin_user_id');
        $data = $request->input('data');
        
        // Initialize an empty response array
        $response = [];

        // Loop through each data entry to fetch matching records
        foreach ($data as $item) {

            $date = $item['date'];
            $slotId = $item['slot_id'];
            $startTime = $item['start_time'];
            $endTime = $item['end_time'];

            // Query to fetch TA scheduling records based on criteria
            $records = TACoachScheduling::with(['students.studentBatchMappings.batch'])
            ->where('admin_user_id', $admin_user_id)
            ->where('slot_id', $slotId)
            ->where('is_deleted', false)
            ->whereDate('date', $date)
            ->whereTime('start_time', '>=', $startTime)
            ->whereTime('end_time', '<=', $endTime)
            ->get();

            $formattedRecords = $records->map(function ($record) {
                $students = $record->students->map(function ($student) {
                    return [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'academic_term' => $student->academic_term,
                        'email' => $student->email,
                        'phone' => $student->phone,
                        'is_active' => $student->is_active,
                        'batches' => $student->studentBatchMappings->map(function ($mapping) {
                            return [
                                'batch_id' => $mapping->batch->id,
                                'batch_name' => $mapping->batch->name,
                                'branch' => $mapping->batch->branch,
                                'is_active' => $mapping->batch->is_active
                            ];
                        })
                    ];
                });

                return [
                    'id' => $record->id,
                    'admin_user_id' => $record->admin_user_id,
                    'meeting_name' => $record->meeting_name,
                    'meeting_url' => $record->meeting_url,
                    'date' => $record->date,
                    'slot_id' => $record->slot_id,
                    'start_time' => $record->start_time,
                    'end_time' => $record->end_time,
                    'time_zone' => $record->time_zone,
                    'is_active' => $record->is_active,
                    'event_status' => $record->event_status,
                    'is_deleted' => $record->is_deleted,
                    'created_by' => $record->created_by,
                    'updated_by' => $record->updated_by,
                    'Students' => $students
                ];
            });

            // Merge fetched records into response array
            $response = array_merge($response, $formattedRecords->toArray());
        }
    
        // Prepare and return response based on fetched records
        if ($response) {
            return [
                'status' => true,
                'message' => __('Admin::response_message.schedules.schedule_retrieve'),
                'data' => $response,
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Admin::response_message.schedules.schedule_not_found'),
            ];
        }        
    }

}
