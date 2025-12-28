<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|max:60',
            'name' => 'required|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'required|regex:/^\+?[0-9\s]{8,20}$/',
            'comment' => 'max:500',
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
