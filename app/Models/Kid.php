<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;

class Kid extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'kids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'nick_name',
        'name',
        'last_name',
        'first_name',
        'birthday',
        'learning_style',
    ];

    protected function birthday(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::now()->year - Carbon::create($value)->year,
        );
    }

    protected function birthdayOrigin(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['birthday'],
        );
    }

}
