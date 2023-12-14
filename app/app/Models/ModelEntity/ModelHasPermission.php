<?php

namespace App\Models\ModelEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'model_has_permissions';

    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id'
    ];
}
