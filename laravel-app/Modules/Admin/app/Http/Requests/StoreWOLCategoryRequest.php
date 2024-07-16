<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWOLCategoryRequest extends FormRequest
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
            'name' => 'required|string|unique:wol_category,name',
        ];
    } 

    public function messages()
    {
        return [
            'name.required' => __('Admin::validation_message.wol_tools.name_required'),
            'name.string' => __('Admin::validation_message.wol_tools.name_string'),
            'name.unique' => __('Admin::validation_message.wol_tools.name_unique'),            
        ];
    }
}
