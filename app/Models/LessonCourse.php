<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonCourse extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'lesson_id',
        'title',
        'deadline',
        'date',
        'start_time',
        'end_time',
        'max_seat',
        'weekday',
        'note',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'weekday'   => 'array',
    ];

    protected $with = [
        'course_applications',
        'course_schedules',
    ];

    public function course_applications()
    {
        return $this->hasMany(\App\Models\CourseApplication::class, 'course_id');
    }

    public function course_schedules()
    {
        return $this->hasMany(\App\Models\CourseSchedule::class, 'course_id');
    }

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id');
    }
}
