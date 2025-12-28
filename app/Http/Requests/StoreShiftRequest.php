<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreShiftRequest extends FormRequest
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
            'category' => 'max:200',
            'description' => 'max:500',
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'team_size' => 'required|int|max:100|min:0|numeric',
            'contact_name' => 'max:200',
            'contact_email' => 'nullable|email|max:200',
            'contact_phone' => 'nullable|regex:/^\+?[0-9\s]{8,20}$/|max:200',
        ];
    }

    /**
     * Messages for validation errors
     * @return string[]
     */
    public function messages()
    {
        return [
            // 'title.required' => __("shift.titleRequired"),
            // 'start.required'  => __('shift.startRequired'),
            // 'start.before'  => __('shift.startBefore'),
            // 'end.required'  => __('shift.endRequired'),
            // 'end.after'  => __('shift.endAfter'),
            // 'team_size.required'  => __('shift.team_sizeRequired'),
        ];
    }
}
