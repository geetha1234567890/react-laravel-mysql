<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLDataRequest extends FormRequest
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
            'name' => 'required|string|unique:wol_coaching_tools_data,name',
            'coaching_tool_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Admin::validation_message.wol_tools.name_required'),
            'name.string' => __('Admin::validation_message.wol_tools.name_string'),
            'name.unique' => __('Admin::validation_message.wol_tools.name_unique'),
            'coaching_tool_id.required' => __('Admin::validation_message.wol_tools.coaching_tool_id_required'),
            'coaching_tool_id.integer' => __('Admin::validation_message.wol_tools.coaching_tool_id_integer'),
            
        ];
    }
}
