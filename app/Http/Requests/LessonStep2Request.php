<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class LessonStep2Request extends FormRequest
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
            'cover_image'              => 'required|mimes:jpeg,png,jpg,gif,bmp',
            'short_video_for_parent'   => 'required|mimetypes:video/avi,video/mov,video/mp4,video/webm,video/flv|max:102400',
            'short_video_for_learner'  => 'nullable|mimetypes:video/avi,video/mov,video/mp4,video/webm,video/flv|max:102400',
            'template'                 => 'nullable',
            'lesson_content'           => 'required|min:500|max:10000',
            'teacher_experience'       => 'required|min:200|max:10000',
            'note'                     => 'nullable|max:10000',
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
            'cover_image'              => __('label.lesson.field.cover_image'),
            'short_video_for_parent'   => __('label.lesson.field.short_video_for_parent'),
            'short_video_for_learner'  => __('label.lesson.field.short_video_for_learner'),
            'template'                 => __('label.lesson.field.template'),
            'lesson_content'           => __('label.lesson.field.lesson_content'),
            'teacher_experience'       => __('label.lesson.field.teacher_experience'),
            'note'                     => __('label.lesson.field.note'),
        ];
    }
}
