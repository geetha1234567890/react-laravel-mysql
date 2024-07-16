<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityPrerequisiteRequest extends FormRequest
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
            'activity_id' => 'required|exists:coaching_template_module_activities,id',
            'template_id' => 'required|exists:coaching_templates,id',
            'is_locked' => 'required|boolean',
            'is_active' => 'required|boolean',
            'created_by' => 'nullable|exists:admin_users,id',
            'updated_by' => 'nullable|exists:admin_users,id',
            'lock_until_date' => 'required|date',
            'time' => 'required',
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
            'activity_id.required' => __('Admin::validation_message.coaching_template.activity_id_required'),
            'activity_id.exists' => __('Admin::validation_message.coaching_template.activity_id_exists'),
            'template_id.required' => __('Admin::validation_message.coaching_template.template_id_required'),
            'template_id.exists' => __('Admin::validation_message.coaching_template.template_id_exists'),
            'is_locked.required' => __('Admin::validation_message.coaching_template.is_locked_required'),
            'is_locked.boolean' => __('Admin::validation_message.coaching_template.is_locked_boolean'),
            'is_active.required' => __('Admin::validation_message.coaching_template.is_active_required'),
            'is_active.boolean' => __('Admin::validation_message.coaching_template.is_active_boolean'),
            'created_by.exists' => __('Admin::validation_message.coaching_template.created_by_exists'),
            'updated_by.exists' => __('Admin::validation_message.coaching_template.updated_by_exists'),
            'lock_until_date.required' => __('Admin::validation_message.coaching_template.lock_until_date_required'),
            'lock_until_date.date' => __('Admin::validation_message.coaching_template.lock_until_date_date'),
            'time.required' => __('Admin::validation_message.coaching_template.time_required'),
        ];
    }
}

