<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class LessonStep1Request extends FormRequest
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

        return [
            'title'            => 'required|max:100',
            'category_id'      => 'required',
            'description'      => 'required|max:100',
            'target_age_from'  => 'required',
            'target_age_to'    => 'required',
            'min_learner'      => 'required',
            'max_learner'      => 'required',
            'language'         => 'required',
            'style'            => 'required',
            'number_of_meets'  => 'required',
            'lesson_hour'      => 'required',
            'lesson_minute'    => $data['lesson_hour'] === 0 ? 'gt:0' : 'required',
            'total_of_meets'   => $data['weekday'] ? 'gt:'.count($data['weekday']) - 1 : 'required',
            'currency'         => 'required',
            'price'            => 'required|numeric|min:0|not_in:0',
            'weekday'          => $data['number_of_meets'] ? ["array","min:".$data['number_of_meets'],"max:".$data['number_of_meets']] : 'required',
            'start_time'       => 'required',
            'end_time'         => 'required',
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
            'title'            => __('label.lesson.field.title'),
            'category_id'      => __('label.lesson.field.category_id'),
            'description'      => __('label.lesson.field.description'),
            'target_age_from'  => __('label.lesson.field.target_age_from'),
            'target_age_to'    => __('label.lesson.field.target_age_to'),
            'min_learner'      => __('label.lesson.field.min_learner'),
            'max_learner'      => __('label.lesson.field.max_learner'),
            'language'         => __('label.lesson.field.language'),
            'style'            => __('label.lesson.field.style'),
            'number_of_meets'  => __('label.lesson.field.number_of_meets'),
            'lesson_hour'      => __('label.lesson.field.lesson_hour'),
            'lesson_minute'    => __('label.lesson.field.lesson_minute'),
            'total_of_meets'   => __('label.lesson.field.total_of_meets'),
            'currency'         => __('label.lesson.field.currency'),
            'price'            => __('label.lesson.field.price'),
            'weekday'          => __('label.lesson_schedule.field.weekday'),
            'start_time'       => __('label.lesson_schedule.field.start_time'),
            'end_time'         => __('label.lesson_schedule.field.end_time'),
        ];
    }
}
