<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTACoachSlotsRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Always returns true because authorization is handled elsewhere.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array Validation rules defined for the request parameters.
     */
    public function rules()
    {
        // return [
        //     'admin_user_id' => 'required|integer',
        //     'slot_date' => 'required|date',
        //     'from_time' => 'required|date_format:H:i:s',
        //     'to_time' => 'required|date_format:H:i:s|after:from_time',
        //     'timezone' => 'required|string',
        //     'series' => 'integer|nullable',
        // ];
        $rules = [
            'admin_user_id' => 'required|integer',
            'slot_date' => 'required|date',
            'from_time' => 'required|date_format:H:i:s',
            'to_time' => 'required|date_format:H:i:s|after:from_time',
            'timezone' => 'required|string',
            'series' => 'integer|nullable',
        ];
    
        if ($this->isMethod('post')) {
            // Rules for creating a new record
            //$rules['additional_field'] = 'required|string';
            // Add more rules specific to the create request
        }
    
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating an existing record
            $rules['admin_user_id'] = 'sometimes|required|integer';
            $rules['slot_date'] = 'sometimes|required|date';
            // Add more rules specific to the update request
        }
    
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array Custom error messages for specific validation rules.
     */
    public function messages()
    {
        return [
            'admin_user_id.required' => __('Admin::validation_message.admin_id_required'),
            'admin_user_id.integer' => __('Admin::validation_message.admin_id_integer'),
    
            'slot_date.required' => __('Admin::validation_message.slots.slot_date_required'),
            'slot_date.date' =>  __('Admin::validation_message.slots.slot_date_valid'),
    
            'from_time.required' => __('Admin::validation_message.slots.from_time_required'),
            'from_time.date_format' => __('Admin::validation_message.slots.from_time_date_format'),
    
            'to_time.required' => __('Admin::validation_message.slots.to_time_required'),
            'to_time.date_format' => __('Admin::validation_message.slots.to_time_date_format'),
            'to_time.after' => __('Admin::validation_message.slots.to_time_after'),
    
            'timezone.required' => __('Admin::validation_message.timezone_required'),
            'timezone.string' => __('Admin::validation_message.timezone_string'),

            'series.integer' => __('Admin::validation_message.slots.series_integer'),
        ];
    }
}
