<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Request extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'summary',
        'detail',
        'min_price',
        'max_price',
        'about_teacher',
        'language',
        'min_time',
        'max_time',
        'start_time',
        'end_time',
        'min_age',
        'max_age',
        'weekdays',
        'status',
    ];

    /**
     * @var array
     */
    protected $with = [
        'applications',
    ];

    /**
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(\App\Models\RequestApplication::class);
    }
}
