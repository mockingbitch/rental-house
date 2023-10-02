<?php

namespace App\Models;

use App\Constants\CategoryConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_vi',
        'name_en',
        'description_vi',
        'description_en',
        'icon',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case CategoryConstant::STATUS_VALUE_0:
                $type = CategoryConstant::TYPE[CategoryConstant::STATUS_VALUE_0];
                break;
            case CategoryConstant::STATUS_VALUE_1:
                $type = CategoryConstant::TYPE[CategoryConstant::STATUS_VALUE_1];
                break;
            default:
                $type = "";
        }
        return $type;
    }
}
