<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Project extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required',
            'name' => 'required',
            'embed_url' => 'required|url',
            'action_date' => 'required|date',
        ];
    }
}
