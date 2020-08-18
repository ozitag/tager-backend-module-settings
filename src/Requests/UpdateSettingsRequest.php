<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Requests;

use OZiTAG\Tager\Backend\Core\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'values' => 'required',
            'values.*' => 'array',
            'items.*.field' => 'string|required',
            'items.*.value' => 'nullable',
        ];
    }
}
