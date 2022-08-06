<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentCategory extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('content_categories', 'name')->ignore($this->id, 'id'),
            ],
            'description' => 'required',
            'is_active' => 'required',
            'is_display' => 'required',
        ];
    }
}
