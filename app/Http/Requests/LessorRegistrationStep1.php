<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessorRegistrationStep1 extends FormRequest
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
        $rules = [
            'firstName'     => 'required|string|max:100',
            'lastName'      => 'required|string|max:100',
            'year'          => 'required',
            'month'         => 'required',
            'day'           => 'required',
            'phone'         => 'required|min:9|max:11',
            'about'         => 'required|max:500',
            'shortVideo'    => 'nullable|mimetypes:video/avi,video/mov,video/mp4,video/webm,video/flv|max:30000',
        ];

        if (!is_string($this->profileImage)):
            $rules = array_merge($rules, [
                'profileImage' => 'required|mimes:jpeg,png,jpg,gif,bmp',
            ]); 
        endif;
        
        if ($this->year && $this->month && $this->day):
            $rules = array_merge($rules, [
                'birthday'     => 'date|before:today',
            ]); 
        endif;
        
        return $rules;
    }
}
