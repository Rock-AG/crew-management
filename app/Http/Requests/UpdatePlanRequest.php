<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:200',
            'description' => 'required|max:500',
            'contact' => 'max:500',
            'allow_unsubscribe' => 'boolean',
            'allow_subscribe' => 'boolean',
            'show_on_homepage' => 'boolean',
        ];
    }

    /**
     * Messages for validation errors
     * @return string[]
     */
    public function messages()
    {
        return [

        ];
    }
}
