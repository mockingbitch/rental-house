<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'category_id',
        'title',
        'price',
        'description',
        'target_age_from',
        'target_age_to',
        'min_learner',
        'max_learner',
        'number_of_meets',
        'lesson_hour',
        'lesson_minute',
        'total_of_meets',
        'language',
        'style',
        'currency',
        'cover_image',
        'short_video_for_parent',
        'short_video_for_learner',
        'template',
        'lesson_content',
        'teacher_experience',
        'start_date',
        'end_date',
        'note',
        'status',
    ];

    protected $with = [
        'course',
        'review',
        'teacher',
    ];

    public function teacher()
    {
        return $this->belongsTo(\App\Models\User::class, 'teacher_id');
    }

    public function course()
    {
        return $this->hasMany(\App\Models\LessonCourse::class);
    }

    public function review()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class);
    }

    public function request_application()
    {
        return $this->hasMany(\App\Models\RequestApplication::class);
    }

    protected $casts = [
        'start_date' => 'date:Y/m/d',
        'end_date' => 'date:Y/m/d',
    ];
}
