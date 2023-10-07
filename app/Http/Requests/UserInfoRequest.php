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
        $data = $this->all();
        if(!$data['confirm']) :

            return [
                'avatar'        => 'required|' . ($this->isUploadNewAvatar ? 'mimes:jpeg,png,jpg,gif,bmp' : 'string'),
                'province'      => 'required',
                'district'      => 'required',
                'ward'          => 'required',
                'first_name'    => 'required|max:50',
                'last_name'     => 'required|max:50',
                'year'          => 'required',
                'month'         => 'required',
                'day'           => 'required',
                'birthday'      => 'required'
            ];
        endif;

            return [];
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'first_name'    => __('label.user.field.firstName'),
            'last_name'     => __('label.user.field.lastName'),
            'birthday'      => __('label.user.field.birthday')
        ];
    }
}
?>
