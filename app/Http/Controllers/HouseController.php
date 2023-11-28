<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HouseRequest;
use App\Repositories\House\HouseRepositoryInterface;
use App\Services\FileService;

class HouseController extends Controller
{
    /**
     * @param HouseRepositoryInterface $houseRepository
     */
    public function __construct(
        public HouseRepositoryInterface $houseRepository,
        public FileService $fileService,
    )
    {
    }

    public function create(HouseRequest $request)
    {
        $data = $request->all();
        try {
            $data['lessor_id'] = auth()->user()->id;
            $data['thumbnail'] = $this->fileService
                ->storeFile($data['thumbnail'], 'public/house');
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
