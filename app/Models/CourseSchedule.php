<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'course_schedules';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'course_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    protected $with = [
        'userSchedule',
    ];

    public function lessonCourse()
    {
        return $this->belongsTo(\App\Models\LessonCourse::class, 'course_id');
    }

    public function userSchedule()
    {
        return $this->hasMany(\App\Models\UserSchedule::class, 'schedule_id');
    }
}
