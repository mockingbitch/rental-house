<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'course_applications';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'course_id',
        'user_id',
        'learner_question',
        'payment_intent_id',
        'status',
        'cancel_reason',
    ];

    protected $with = [
        'application_details',
    ];

    public function lessonCourse()
    {
        return $this->belongsTo(\App\Models\LessonCourse::class, 'course_id');
    }

    public function application_details()
    {
        return $this->hasMany(\App\Models\ApplicationDetail::class, 'application_id');
    }
}
