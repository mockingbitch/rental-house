<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\House\HouseRepositoryInterface;

class HouseController extends Controller
{
    public function __construct(
        public HouseRepositoryInterface $houseRepository,
    )
    {

    }

    public function create(Request $request)
    {
        $data = $request->all();
        try {
            $this->houseRepository->create($data);

            return redirect()
                ->route('lessor.house.index')
                ->with('errCode', 1);
        } catch (\Throwable $th) {
            return redirect()
                ->route('lessor.house.index')
                ->with('errCode', 0);
        }
    }

    public function detail()
    {

    }

    public function delete()
    {
        
    }
}
