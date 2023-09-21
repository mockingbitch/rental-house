<?php

namespace App\Http\Requests;

use App\Constants\CommonConstants;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\HalfWidth;
use App\Constants\UserConstants;

class ForgotPasswordRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // last rule represent for only accept email exist on DB and has 'vendor' field = 1
        return [
            'email'     => [
                'required',
                'email',
                'max:255',
                new HalfWidth,
                'exists:App\Models\User,email,vendor,'.UserConstants::VENDOR_EMAIL
            ],
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'email'     => __('label.user.field.email'),
            'password'  => __('label.user.field.password'),
        ];
    }
}
