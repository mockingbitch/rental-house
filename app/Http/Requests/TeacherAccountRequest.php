<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class TeacherAccountRequest extends BaseRequest
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
            'profile_image'     => 'nullable|mimes:jpeg,png,jpg,gif,bmp',
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'city_id'           => 'required',
            'year'              => 'required',
            'month'             => 'required',
            'day'               => 'required',
            // 'email'             => ['required','email','unique:App\Models\TeacherInformation,email','max:255'],
            'country_code'      => 'required',
            'phone'             => 'required|min:9|max:11',
            'job'               => 'required',
            'salary'            => 'required',
            'headline'          => 'required|max:80',
            'about'             => 'required|max:200',
            'short_video_for_learner' => 'nullable|mimetypes:video/avi,video/mov,video/mp4,video/webm,video/flv|max:90000',
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
            'profile_image'         => [
                'required'  => '必須項目です',
                'mimes'     => 'ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください',
            ],
            'first_name'            => [
                'required'  => 'First Nameを入力してください',
                'max'       => 'First Nameは100文字以内に入力してください',
            ],
            'last_name'             => [
                'required'  => 'Last Nameを入力してください',
                'max'       => 'Last Nameは100文字以内に入力してください',
            ],
            'city_id.required'      => '選択してください',
            'email'                 => [
                'email'     => 'Email が正しくありません。Email を正しく入力してください',
                'unique'    => 'このメールアドレスは既に使われています。再度ご確認ください',
            ],
            'year.required'         => '必須項目です',
            'month.required'        => '必須項目です',
            'day.required'          => '必須項目です',
            'country_code.required' => '必須項目です',
            'phone'                 => [
                'required'  => '必須項目です',
                'min'       => 'Phone Numbersは9数字以上に入力してください',
                'max'       => 'Phone Numbersは11数字以内に入力してください',
            ],
            'job.required'          => '選択してください',
            'salary.required'       => '選択してください',
            'headline'              => [
                'required'  => 'Headline of teacherを入力してください',
                'max'       => 'Headline of teacherは80文字以内に入力してください',
            ],
            'about'                 => [
                'required'  => '選択してください',
                'max'       => 'About meは200文字以内に入力してください',
            ],
            'short_video_for_learner' => [
                'mimetypes' => 'ファイル形式が正しくありません。MP4、AVI、MOV、WEBM、FLV形式の画像をアップロードしてください',
                'max'       => ' 100MB以下のファイルをアップロードしてください',
            ],
        ];
    }
}
