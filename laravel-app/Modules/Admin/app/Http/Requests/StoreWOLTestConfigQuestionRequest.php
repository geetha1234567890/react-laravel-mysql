<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLTestConfigQuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'wol_category_id' => 'required|integer',
            'wol_questions_id'=>'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'wol_questions_id.required' => __('Admin::validation_message.wol_tools.question_required'),
            'wol_questions_id.integer' => __('Admin::validation_message.wol_tools.wol_question_id_integer'),
            'question.unique' => __('Admin::validation_message.wol_tools.question_unique'),
            'wol_category_id.required' => __('Admin::validation_message.wol_tools.wol_category_id_required'),
            'wol_category_id.integer' => __('Admin::validation_message.wol_tools.wol_category_id_integer'),
        ];
    }
}
