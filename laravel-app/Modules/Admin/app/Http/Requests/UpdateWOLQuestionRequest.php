<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWOLQuestionRequest extends FormRequest
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
            'question' => 'required|string|unique:wol_questions,question',
            'wol_category_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'question.required' => __('Admin::validation_message.wol_tools.question_required'),
            'question.string' => __('Admin::validation_message.wol_tools.question_string'),
            'question.unique' => __('Admin::validation_message.wol_tools.question_unique'),
            'wol_category_id.required' => __('Admin::validation_message.wol_tools.wol_category_id_required'),
            'wol_category_id.integer' => __('Admin::validation_message.wol_tools.wol_category_id_integer'),
            
        ];
    }
}
