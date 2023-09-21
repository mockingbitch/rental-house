<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'required'  => __('validation.required'),
            'min'       => __('validation.min.string'),
            'max'       => __('validation.max.string'),
            'email'     => __('validation.email'),
            'password_confirmation' => __('validation.password_confirmation'),
            'exists'    => __('validation.exists'),
        ];
    }

}
