<?php

namespace App\Models\ModelEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'model_has_roles';

    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];
}
