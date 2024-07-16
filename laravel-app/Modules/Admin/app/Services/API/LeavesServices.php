<?php 
    namespace Modules\Admin\Services\API;

    use Modules\Admin\Models\Leaves;
    use Carbon\Carbon;

    class LeavesServices
    {

        /**
         * Store leave method to create a new leave record.
         *
         * @param \Illuminate\Http\Request $request The incoming request object containing admin_user_id, start_date, and end_date.
         * @return array Status of the operation (true/false), message, and data (leave record).
         */
        public function storeLeave($request)
        {
            // Extract request parameters
            $admin_user_id = $request->admin_user_id;
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $approve_status = $request->approve_status ?? 1;
            $leave_type = $request->leave_type ?? 'full';
            $message = $request->reason ?? null;

            // Create new leave record
            $leave = Leaves::create([
                'admin_user_id'=>$admin_user_id,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
                'approve_status'=>$approve_status,
                'leave_type'=>$leave_type,
                'message'=>$message
            ]);

            // Check if leave record creation was successful
            if($leave){
                return [
                    'status'=>true,
                    'message' => __('Admin::response_message.leave.leave_store'),
                    'data'=>$leave,
                ];
            }else{
                return [
                    'status'=>false,
                    'message' => __('Admin::response_message.leave.store_leave_failed'),
                ];
            }

        }

    }
?>