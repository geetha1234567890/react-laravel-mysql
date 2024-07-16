<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLTestConfigRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'number_of_categories' => 'required|integer',
            'categories' => 'array',
            'categories.*.wol_category_id' => 'required|exists:wol_category,id',
            'categories.*.number_of_questions' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'number_of_categories.required' => __('Admin::validation_message.wol_tools.number_of_categories_required'),
            'number_of_categories.integer' => __('Admin::validation_message.wol_tools.number_of_categories_integer'),
            'categories.array' => __('Admin::validation_message.wol_tools.categories_array'),
            'categories.*.wol_category_id.required' => __('Admin::validation_message.wol_tools.wol_category_id_required'),
            'categories.*.wol_category_id.exists' => __('Admin::validation_message.wol_tools.wol_category_id_exists'),
            'categories.*.number_of_questions.required' => __('Admin::validation_message.wol_tools.number_of_questions_required'),
            'categories.*.number_of_questions.integer' => __('Admin::validation_message.wol_tools.number_of_questions_integer'),
            
        ];
    }
}
