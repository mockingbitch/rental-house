<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use App\Constants\CountryConstants;
use Illuminate\Validation\Rule;
use App\Rules\Kana;
use App\Rules\HalfWidth;
use Illuminate\Foundation\Http\FormRequest;

class OnboardingStep1Request extends FormRequest
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
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'city_id'           => 'required',
            'year'              => 'required',
            'month'             => 'required',
            'day'               => 'required',
            'email'             => ['required','email','unique:App\Models\TeacherInformation,email','max:255', new HalfWidth],
            'country_code'      => 'required',
            'phone'             => 'required|min:9|max:11',
            'job'               => 'required',
            'salary'            => 'required',
            'headline'          => 'required|max:80',
            'about'             => 'required|max:200',
            'short_video_for_learner' => 'nullable|mimetypes:video/avi,video/mov,video/mp4,video/webm,video/flv|max:90000',
        ];

        if (!is_string($this->profile_image)):
            $rules = array_merge($rules, [
                'profile_image'     => 'required|mimes:jpeg,png,jpg,gif,bmp',
            ]); 
        endif;

        if ($this->country_id == CountryConstants::COUNTRY_JP['id']):
            $rules = array_merge($rules, [
                'first_name_kana'     => ['required', 'max:100', new Kana],
                'last_name_kana'      => ['required', 'max:100', new Kana],
            ]); 
        endif;
        
        if ($this->year && $this->month && $this->day):
            $rules = array_merge($rules, [
                'birthday'     => 'date|before:today',
            ]); 
        endif;
        
        return $rules;
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        return [
            'first_name_kana' => __('label.user.field.first_name_kana'),
            'last_name_kana'  => __('label.user.field.last_name_kana'),
        ];
    }

    /**
     * Get the messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    // public function messages()
    // {
    //     return [
    //         'profile_image'         => [
    //             'required'  => '必須項目です',
    //             'mimes'     => 'ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください',
    //         ],
    //         'first_name'            => [
    //             'required'  => 'First Nameを入力してください',
    //             'max'       => 'First Nameは100文字以内に入力してください',
    //         ],
    //         'first_name_kana'       => [
    //             'required'  => 'First Nameを入力してください',
    //             'max'       => 'First Nameは100文字以内に入力してください',
    //         ],
    //         'last_name'             => [
    //             'required'  => 'Last Nameを入力してください',
    //             'max'       => 'Last Nameは100文字以内に入力してください',
    //         ],
    //         'last_name_kana'        => [
    //             'required'  => 'Last Nameを入力してください',
    //             'max'       => 'Last Nameは100文字以内に入力してください',
    //         ],
    //         'city_id.required'      => '選択してください',
    //         'email'                 => [
    //             'email'     => 'Email が正しくありません。Email を正しく入力してください',
    //             'unique'    => 'このメールアドレスは既に使われています。再度ご確認ください',
    //         ],
    //         'year.required'         => '必須項目です',
    //         'month.required'        => '必須項目です',
    //         'day.required'          => '必須項目です',
    //         'country_code.required' => '必須項目です',
    //         'phone'                 => [
    //             'required'  => '必須項目です',
    //             'min'       => 'Phone Numbersは9数字以上に入力してください',
    //             'max'       => 'Phone Numbersは11数字以内に入力してください',
    //         ],
    //         'job.required'          => '選択してください',
    //         'salary.required'       => '選択してください',
    //         'headline'              => [
    //             'required'  => 'Headline of teacherを入力してください',
    //             'max'       => 'Headline of teacherは80文字以内に入力してください',
    //         ],
    //         'about'                 => [
    //             'required'  => '選択してください',
    //             'max'       => 'About meは200文字以内に入力してください',
    //         ],
    //         'short_video_for_learner' => [
    //             'mimetypes' => 'ファイル形式が正しくありません。MP4、AVI、MOV、WEBM、FLV形式の画像をアップロードしてください',
    //             'max'       => ' 100MB以下のファイルをアップロードしてください',
    //         ],
    //     ];
    // }
}
