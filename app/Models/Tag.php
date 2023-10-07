<?php

namespace App\Models;

use App\Constants\TagConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var array
     */
    protected $fillable = [
        'name_vi',
        'name_en',
        'description_vi',
        'description_en',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case TagConstant::STATUS_VALUE_0:
                $type = TagConstant::TYPE[TagConstant::STATUS_VALUE_0];
                break;
            case TagConstant::STATUS_VALUE_1:
                $type = TagConstant::TYPE[TagConstant::STATUS_VALUE_1];
                break;
            default:
                $type = "";
        }
        return $type;
    }
}
