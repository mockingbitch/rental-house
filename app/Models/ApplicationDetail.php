<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'kid_id',
        'status',
    ];

    protected $with = [
        'kids',
    ];

    public function kids()
    {
        return $this->belongsTo(\App\Models\Kid::class, 'kid_id');
    }
}
