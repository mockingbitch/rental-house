<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'lessor_id',
        'name',
        'description',
        'province_code',
        'district_code',
        'ward_code',
        'address',
        'verified_at',
        'thumbnail',
        'status',
        'category_id',
    ];

    /**
     * @return BelongsTo
     */
    public function lessor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'lessor_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(\App\Models\Room::class, 'house_id');
    }
}
