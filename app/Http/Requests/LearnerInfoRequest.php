<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LearnerInfoRequest extends FormRequest
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
            'kids.*.nickName'           => 'required|max:100|distinct',
            'kids.*.firstName'          => 'required|max:100',
            'kids.*.lastName'           => 'required|max:100',
            'kids.*.name'               => 'distinct',
            'kids.*.year'               => 'required',
            'kids.*.month'              => 'required',
            'kids.*.day'                => 'required',
            'kids.*.birthday'           => 'required|date|before:today',
            'kids.*.categories'         => 'min:1',
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
            'kids.*.nickName'           => __('label.information.learner_info.nickname'),
            'kids.*.firstName'          => __('label.information.learner_info.kid_first_name'),
            'kids.*.lastName'           => __('label.information.learner_info.kid_last_name'),
            'kids.*.name'               => __('label.information.learner_info.name'),
            'kids.*.birthday'           => __('label.information.learner_info.birthday'),
        ];
    }


}
