<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class LessonCreateRequest extends FormRequest
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
            'file_upload'         => 'required|array|min:3',
            'file_upload.*'       => 'nullable|mimes:pdf',
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
            'file_upload'             => __('label.lesson.field.file'),
        ];
    }
}
