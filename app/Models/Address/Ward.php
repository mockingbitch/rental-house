<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'wards';

    /**
     * @return BelongsTo
     */
    public function district() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\District::class, 'district_code', 'code');
    }

    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\AdministrativeUnit::class, 'administrative_unit_id');
    }
}
