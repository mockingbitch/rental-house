<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'feedbacks';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'lesson_id',
        'score',
        'detail',
        'status',
    ];

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id');
    }
}
