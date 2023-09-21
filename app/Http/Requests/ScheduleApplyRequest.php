<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class ScheduleApplyRequest extends FormRequest
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
            'applyKids'         => 'required|array',
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
            'applyKids' => __('label.schedule_application.field.kid'),
        ];
    }
}
