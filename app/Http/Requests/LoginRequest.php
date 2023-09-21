<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\HalfWidth;

class LoginRequest extends FormRequest
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
            'email'     => ['required','email','max:255', new HalfWidth],
            'password'  => ['required','min:6','max:20', new HalfWidth],
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
