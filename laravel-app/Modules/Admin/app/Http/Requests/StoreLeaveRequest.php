<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_user_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'admin_user_id.required' => __('Admin::validation_message.admin_id_required'),
            'admin_user_id.integer' => __('Admin::validation_message.admin_id_integer'),

            'start_date.required' =>  __('Admin::validation_message.leave.start_date_required'),
            'start_date.date' =>  __('Admin::validation_message.leave.start_date_date'),

            'end_date.required' =>  __('Admin::validation_message.leave.end_date_required'),
            'end_date.date' => __('Admin::validation_message.leave.end_date_date'),
            'end_date.after' => __('Admin::validation_message.leave.end_date_after'),
        ];
    }

}
