<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'districts';

    /**
     * @return BelongsTo
     */
    public function province() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\Province::class, 'province_code', 'code');
    }

    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\AdministrativeUnit::class, 'administrative_unit_id');
    }
}
