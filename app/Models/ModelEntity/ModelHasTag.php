<?php

namespace App\Models\ModelEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasTag extends Model
{
    use HasFactory;

    protected $table = 'model_has_tags';

    protected $fillable = [
        'tag_id',
        'model_type',
        'model_id'
    ];
}
