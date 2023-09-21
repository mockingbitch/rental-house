<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Review extends Model
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
        'user_id',
        'review',
        'rate',
        'status',
        'beneficial',
        'ease_of_understanding',
        'good_at_teaching',
        'enjoyable',
    ];

    /**
     * @var array
     */
    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::create($value)->format('Y/m/d')
        );
    }
}
