<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkActivityRequest extends FormRequest
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
            'activity_id' => 'required|exists:coaching_template_module_activities,id',
            'activity_type_id' => 'required|exists:coaching_template_activity_types,id',
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
            'activity_type_id.required' => __('Admin::validation_message.coaching_template.activity_type_id_required'),
            'activity_type_id.exists' => __('Admin::validation_message.coaching_template.activity_type_id_exists'),
            'activity_id.required' => __('Admin::validation_message.coaching_template.activity_id_required'),
            'activity_id.exists' => __('Admin::validation_message.coaching_template.activity_id_exists'),
        ];
    }
}
