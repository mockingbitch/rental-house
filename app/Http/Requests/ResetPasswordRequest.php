<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\HalfWidth;

class ResetPasswordRequest extends FormRequest
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
        return [
            'password'  => ['required','min:6','max:20', new HalfWidth],
            'password_confirmation'  => ['required','min:6','max:20', 'same:password', new HalfWidth],
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
            'password'  => __('label.user.field.password'),
            'password_confirmation'  => __('label.user.field.password_confirmation'),
        ];
    }
}
