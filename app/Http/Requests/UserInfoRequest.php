<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'birthday' => 'required'
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
            'first_name'     => __('label.user.field.firstName'),
            'last_name'  => __('label.user.field.lastName'),
            'birthday'  => __('label.user.field.birthday')
        ];
    }
}
?>
