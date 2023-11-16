<?php

namespace App\Services;

use App\Models\Address\Province;
use App\Models\Address\District;
use App\Models\Address\Ward;

class AddressService
{
    /**
     * @return array
     */
    public function getAddressMst(): array
    {
        return [
            'provinces'  => Province::all(),
            'districts'  => District::all(),
            'wards'      => Ward::all(),
        ];
    }
}