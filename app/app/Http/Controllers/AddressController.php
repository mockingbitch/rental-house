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
    ) {
    }

    public function list(Request $request)
    {
        $data = $request->data;

        $address = $this->addressService->getAddressMst($data);

        return response()->json([
            'address' => $address,
        ], 200);
    }
}
