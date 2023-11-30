<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'ward_id',
        'address',
        'verified_at',
        'thumbnail',
        'status',
        'category_id',
    ];

    public function lessor()
    {
        return $this->belongsTo(\App\Models\User::class, 'lessor_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
