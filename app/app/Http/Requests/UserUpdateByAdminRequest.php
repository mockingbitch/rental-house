<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateByAdminRequest extends FormRequest
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

        // rule for update with new image
        if (array_key_exists('avatar', $data)):
            return [
                'avatar'        => 'required|mimes:jpeg,png,jpg,gif,bmp',
                'first_name'    => 'required|max:50',
                'last_name'     => 'required|max:50',
                'birthday'      => 'required',
                // 'region'        => 'required',
                // 'ward_code'     => 'required',
                'role'          => 'required',
                'status'        => 'required',
                'description'   => 'required',
                // 'year'          => 'required',
                // 'month'         => 'required',
                // 'day'           => 'required',
                // 'province'      => 'required',
                // 'district'      => 'required',
            ];
        // rule for update status
        elseif (count($data) <= 2):
            return [
                'id'            => 'required',
                'status'        => 'required',
            ];
        // rule for update without image
        else:
            return [
                'first_name'    => 'required|max:50',
                'last_name'     => 'required|max:50',
                'birthday'      => 'required',
                // 'region'        => 'required',
                // 'ward_code'     => 'required',
                'role'          => 'required',
                'status'        => 'required',
                'description'   => 'required',
            ];
        endif;
        
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
