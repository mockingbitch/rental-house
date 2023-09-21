<?php

namespace App\Http\Requests;

use App\Constants\CountryConstants;
use App\Http\Requests\BaseRequest;
use App\Rules\Kana;
use Illuminate\Foundation\Http\FormRequest;

class AccountInfoRequest extends FormRequest
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
        $rule = [
            'country'           => 'required',
            'city'              => 'required',
            'nickName'          => 'required|max:100',
            'firstName'         => 'required|max:100',
            'lastName'          => 'required|max:100',
            'year'              => 'required',
            'month'             => 'required',
            'day'               => 'required',
        ];

        if ($this->country && $this->country['id'] === CountryConstants::COUNTRY_JP['id']):
            $rule = array_merge($rule, [
                'firstNameKana'     => ['required', 'max:100', new Kana],
                'lastNameKana'      => ['required', 'max:100', new Kana],
            ]); 
        endif;
        
        if ($this->year && $this->month && $this->day):
            $rule = array_merge($rule, [
                'birthday'     => 'date|before:today',
            ]); 
        endif;

        return $rule;
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'country'       => __('label.user.field.country'),
            'city'          => __('label.user.field.city'),
            'nickName'      => __('label.user.field.adult_nick_name'),
            'firstName'     => __('label.user.field.firstName'),
            'lastName'      => __('label.user.field.lastName'),
            'firstNameKana' => __('label.user.field.first_name_kana'),
            'lastNameKana'  => __('label.user.field.last_name_kana'),
            'email'         => __('label.user.field.email'),
            'birthday'      => __('label.user.field.birthday'),
        ];
    }
}
