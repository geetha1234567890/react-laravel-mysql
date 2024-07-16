<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLCoachingToolRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:coaching_tools,name',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('Admin::validation_message.coaching_template.name_required'),
            'name.string' => __('Admin::validation_message.coaching_template.name_string'),
            'name.unique' => __('Admin::validation_message.coaching_template.name_unique'),
            'is_active.required' => __('Admin::validation_message.coaching_template.is_active_required'),
            'is_active.boolean' => __('Admin::validation_message.coaching_template.is_active_boolean'),
        ];
    }
}
