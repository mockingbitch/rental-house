<?php

namespace App\Models\ModelEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelHasCategory extends Model
{
    use HasFactory;

    protected $table = 'model_has_categories';

    protected $fillable = [
        'category_id',
        'model_type',
        'model_id'
    ];

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }
}
