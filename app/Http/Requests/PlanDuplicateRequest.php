<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanDuplicateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:200',
            'event_date' => 'required|date',
            'description' => 'required|max:500',
            'contact' => 'max:500',
        ];
    }
}
