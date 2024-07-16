<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleActivityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This function returns the validation rules for the request data.
     *
     * @return array The validation rules.
     */
    public function rules()
    {
        return [
            'module_id' => 'required|exists:coaching_template_modules,id',
            'activity_type_id' => 'required|exists:coaching_template_activity_types,id',
            'activity_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'created_by' => 'nullable|exists:admin_users,id',
            'updated_by' => 'nullable|exists:admin_users,id',
            'due_date' => 'required|date',
            'points' => 'required|integer|min:0',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * This function returns the custom error messages for each validation rule.
     *
     * @return array The error messages.
     */
    public function messages()
    {
        return [
            'module_id.required' => __('Admin::validation_message.coaching_template.module_id_required'),
            'module_id.exists' => __('Admin::validation_message.coaching_template.module_id_exists'),
            'activity_type_id.required' => __('Admin::validation_message.coaching_template.activity_type_id_required'),
            'activity_type_id.exists' => __('Admin::validation_message.coaching_template.activity_type_id_exists'),
            'activity_name.required' => __('Admin::validation_message.coaching_template.activity_name_required'),
            'activity_name.string' => __('Admin::validation_message.coaching_template.activity_name_string'),
            'activity_name.max' => __('Admin::validation_message.coaching_template.activity_name_max'),
            'is_active.required' => __('Admin::validation_message.coaching_template.is_active_required'),
            'is_active.boolean' => __('Admin::validation_message.coaching_template.is_active_boolean'),
            'created_by.exists' => __('Admin::validation_message.coaching_template.created_by_exists'),
            'updated_by.exists' => __('Admin::validation_message.coaching_template.updated_by_exists'),
            'due_date.required' => __('Admin::validation_message.coaching_template.due_date_required'),
            'due_date.date' => __('Admin::validation_message.coaching_template.due_date_date'),
            'points.required' => __('Admin::validation_message.coaching_template.points_required'),
            'points.integer' => __('Admin::validation_message.coaching_template.points_integer'),
            'points.min' => __('Admin::validation_message.coaching_template.points_min'),
        ];
    }
}

