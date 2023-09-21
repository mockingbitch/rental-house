<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class OnboardingStep3Request extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'academic_certificate'              => 'nullable|mimes:jpeg,png,jpg,gif,bmp',
            'work_histories.*.work_position'    => 'required',
            'work_histories.*.recruitment_form' => 'required',
            'work_histories.*.company'          => 'required',
            'work_histories.*.work_start_year'  => 'required',
            'work_histories.*.work_start_month' => 'required',
            // 'work_histories.*.work_end_year'    => 'required',
            // 'work_histories.*.work_end_month'   => 'required',
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
        ];
    }

    /**
     * Get the messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'academic_certificate'         => [
                'mimes'     => 'ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください',
            ],
        ];
    }
}
