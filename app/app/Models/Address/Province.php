<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Province extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'provinces';

    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\AdministrativeUnit::class, 'administrative_unit_id');
    }

    /**
     * @return BelongsTo
     */
    public function region() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Address\AdministrativeRegion::class, 'administrative_region_id');
    }
}
