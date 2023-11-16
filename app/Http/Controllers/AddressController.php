<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AddressService;

class AddressController extends Controller
{
    /**
     * @param AddressService $addressService
     */
    public function __construct(
        public AddressService $addressService
    )
    {
    }

    public function list()
    {
        return response()->json([
            'address' => $this->addressService->getAddressMst(),
        ], 200);
    }
}
