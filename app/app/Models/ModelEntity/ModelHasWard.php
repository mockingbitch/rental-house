<?php

namespace App\Models\ModelEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasWard extends Model
{
    use HasFactory;

    protected $table = 'model_has_wards';

    protected $fillable = [
        'model_id',
        'model_type',
        'ward_code'
    ];

    /**
     * @return BelongsTo
     */
    public function ward() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\Ward::class, 'ward_code', 'code');
    }
}
