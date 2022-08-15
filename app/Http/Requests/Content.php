<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Content extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'title' => [
                'required',
                Rule::unique('contents', 'title')->ignore($this->id, 'id'),
            ],
            'is_active' => 'required',
        ];
    }
}
