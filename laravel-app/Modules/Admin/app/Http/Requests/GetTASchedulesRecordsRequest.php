<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTASchedulesRecordsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'admin_user_id' => 'required|integer',
            'data' => 'required|array',
            'data.*.slot_id' => 'required|integer',
            'data.*.date' => 'required|date',
            'data.*.start_time' => 'required|date_format:H:i:s',
            'data.*.end_time' => 'required|date_format:H:i:s|after:data.*.start_time',
        ];

    }
    public function messages()
    {
        return [
            'admin_user_id.required' => __('Admin::validation_message.admin_id_required'),
            'admin_user_id.integer' => __('Admin::validation_message.admin_id_integer'),
        
            'data.required' => __('Admin::validation_message.ta_schedule.data_required'),
            'data.array' => __('Admin::validation_message.ta_schedule.data_array'),
        
            'data.*.slot_id.required' => __('Admin::validation_message.ta_schedule.data_slot_id_required'),
            'data.*.slot_id.integer' => __('Admin::validation_message.ta_schedule.data_slot_id_integer'),
        
            'data.*.date.required' => __('Admin::validation_message.ta_schedule.data_date_required'),
            'data.*.date.date' => __('Admin::validation_message.ta_schedule.data_date_format'),
        
            'data.*.start_time.required' => __('Admin::validation_message.ta_schedule.data_start_time_required'),
            'data.*.start_time.date_format' => __('Admin::validation_message.ta_schedule.data_start_time_date_format'),
        
            'data.*.end_time.required' => __('Admin::validation_message.ta_schedule.data_end_time_required'),
            'data.*.end_time.date_format' => __('Admin::validation_message.ta_schedule.data_end_time_date_format'),
            'data.*.end_time.after' => __('Admin::validation_message.ta_schedule.data_end_time_after'),
        ];
    }

    
}
