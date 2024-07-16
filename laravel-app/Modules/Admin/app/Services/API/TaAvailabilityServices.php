<?php 
    namespace Modules\Admin\Services\API;

    use Carbon\Carbon;
    use Modules\Admin\Models\AdminUsers;
    use Modules\Admin\Models\TACoachSlots;

    class TaAvailabilityServices
    {

        /**
         * Get the (TA) availability for the current date.
         *
         * @return array The response containing status, message, and data if available.
         */
        public function getTaAvailable()
        {

            // Get the current date in 'Y-m-d' format
            $current_date = Carbon::now()->format('Y-m-d');

            // Fetch admin users who have TA coach slots for the current date and have the 'TA' role
            $today_available_ta = AdminUsers::whereHas('roles', function($query) {
                $query->where('role_name', 'TA');
            })->with([
                'taCoachSlots' => function($query) use ($current_date) {
                    $query->where('slot_date', $current_date);
                },
                'roles' => function($query) {
                    $query->where('role_name', 'TA');
                },'taCoachSlots.taCoachScheduling'
            ])->get()->makeHidden('profile_picture');
            

            // Convert the collection to an array

            // TODO : show available status of TA
            $available_ta = $today_available_ta->toArray();

            // Check if any TA is available for today and return the appropriate response
            if ($available_ta) {
                return [
                    'status' => true,
                    'message' => __('Admin::response_message.available_ta.available_ta_retrieve'),
                    'data' => $available_ta,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => __('Admin::response_message.available_ta.available_ta_not_found'),
                ];
            }
        }
    }
?>