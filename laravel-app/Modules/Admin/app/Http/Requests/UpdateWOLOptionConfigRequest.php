<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWOLOptionConfigRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     */
     /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'minimum_scale' => 'required|integer',
            'maximum_scale' => 'required|integer',
            'details' => 'array',
            'details.*.point' => 'integer|required_with:details',
            'details.*.text' => 'nullable|string',
            'details.*.icon' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'minimum_scale.required' => __('Admin::validation_message.minimum_scale_required'),
            'minimum_scale.integer' => __('Admin::validation_message.minimum_scale_integer'),
            'maximum_scale.required' => __('Admin::validation_message.maximum_scale_required'),
            'maximum_scale.integer' => __('Admin::validation_message.maximum_scale_integer'),
            'details.array' => __('Admin::validation_message.details_array'),
            'details.*.point.integer' => __('Admin::validation_message.details_point_integer'),
            'details.*.point.required_with' => __('Admin::validation_message.details_point_required_with'),
            'details.*.text.string' => __('Admin::validation_message.details_text_string'),
            'details.*.icon.string' => __('Admin::validation_message.details_icon_string'),
        ];
    }
}
