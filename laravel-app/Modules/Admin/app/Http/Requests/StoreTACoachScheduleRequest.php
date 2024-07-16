<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTACoachScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'admin_user_id' => 'required|integer',
            'meeting_name' => 'required|string',
            'meeting_url' => 'required|string',
            'schedule_date' => 'required|date',
            'slot_id' => 'required|integer',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:from_time',
            'timezone' => 'required|string',
            'event_status' => 'required|string',
            'studentId' => 'required|array', // studentId should be an array
            'studentId.*' => 'integer', // Each studentId in the array should be an integer
            'batchId' => 'required|array', // batchId should be an array
            'batchId.*' => 'integer', // Each batchId in the array should be an integer
        ];
    }

    public function messages()
    {
        return [
            'admin_user_id.required' => __('Admin::validation_message.admin_id_required'),
            'admin_user_id.integer' => __('Admin::validation_message.admin_id_integer'),

            'meeting_name.required' => __('Admin::validation_message.meeting_name.required'),
            'meeting_name.string' => __('Admin::validation_message.meeting_name.string'),

            'meeting_url.required' => __('Admin::validation_message.meeting_url.required'),
            'meeting_url.string' => __('Admin::validation_message.meeting_url.string'),
    
            'schedule_date.required' => __('Admin::validation_message.date.required'),
            'schedule_date.date' =>  __('Admin::validation_message.date.valid'),
            
            'slot_id.required' => __('Admin::validation_message.slotid.required'),
            'slot_id.integer' => __('Admin::validation_message.slotid.integer'),

            'start_time.required' => __('Admin::validation_message.slots.start_time.required'),
            'start_time.date_format' => __('Admin::validation_message.slots.start_time.date_format'),
    
            'end_time.required' => __('Admin::validation_message.end_time.required'),
            'end_time.date_format' => __('Admin::validation_message.end_time.date_format'),
            'end_time.after' => __('Admin::validation_message.end_time.after'),
    
            'timezone.required' => __('Admin::validation_message.timezone_required'),
            'timezone.string' => __('Admin::validation_message.timezone_string'),

            'event_status.required' => __('Admin::validation_message.event_status.required'),
            'event_status.integer' => __('Admin::validation_message.event_status.string'),

            'studentId.required' => __('Admin::validation_message.studentId.required'),
            'studentId.array' => __('Admin::validation_message.studentId.array'),
            'studentId.*.integer' => __('Admin::validation_message.studentId.integer'),

            'batchId.required' => __('Admin::validation_message.batchId.required'),
            'batchId.array' => __('Admin::validation_message.batchId.array'),
            'batchId.*.integer' => __('Admin::validation_message.batchId.integer'),
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
