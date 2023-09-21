<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestApplication extends Model
{
    use HasFactory;

    protected $table = 'request_applications';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'request_id',
        'lesson_id',
        'status',
    ];

    /**
     * @var array
     */
    protected $with = [
        'lesson'
    ];

    /**
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id');
    }
}
