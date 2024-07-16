<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLLifeInstructionRequest extends FormRequest
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
            'message' => 'required|string|unique:wol_life_instructions,message'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => __('Admin::validation_message.wol_tools.name_required'),
            'message.string' => __('Admin::validation_message.wol_tools.name_string'),
            'message.unique' => __('Admin::validation_message.wol_tools.name_unique')
            
            
        ];
    }
}
