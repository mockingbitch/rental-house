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
    public function getAddressMst($data): array
    {
        if (isset($data['province'])) :
            return [
                'districts' => District::where(
                        'province_code',
                        $data['province']
                    )->get()
            ];
        endif;
        if (isset($data['district'])) :
            return [
                'wards' => Ward::where(
                        'district_code',
                        $data['district']
                    )->get()
            ];;
        endif;

        return [
            'provinces'  => Province::all(),
            'districts'  => District::all(),
            'wards'      => Ward::all(),
        ];
    }
}