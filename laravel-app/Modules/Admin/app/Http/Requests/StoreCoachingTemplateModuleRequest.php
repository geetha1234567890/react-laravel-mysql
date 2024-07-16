<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoachingTemplateModuleRequest extends FormRequest
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
            'template_id' => 'required|exists:coaching_templates,id',
            'module_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'created_by' => 'required|exists:admin_users,id',
            'updated_by' => 'required|exists:admin_users,id',
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
            'template_id.required' =>  __('Admin::validation_message.coaching_template.template_id_required'),
            'template_id.exists' =>  __('Admin::validation_message.coaching_template.template_id_exists'),
            'module_name.required' =>  __('Admin::validation_message.coaching_template.module_name_required'),
            'module_name.string' =>  __('Admin::validation_message.coaching_template.module_name_string'),
            'module_name.max' =>  __('Admin::validation_message.coaching_template.module_name_max'),
            'is_active.required' =>  __('Admin::validation_message.coaching_template.is_active_required'),
            'is_active.boolean' =>  __('Admin::validation_message.coaching_template.is_active_boolean'),
            'created_by.required' =>  __('Admin::validation_message.coaching_template.created_by_required'),
            'created_by.exists' => __('Admin::validation_message.coaching_template.created_by_exists'),
            'updated_by.required' =>  __('Admin::validation_message.coaching_template.updated_by_required'),
            'updated_by.exists' =>  __('Admin::validation_message.coaching_template.updated_by_exists'),
        ];
    }
}

