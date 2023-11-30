<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\HouseRequest;
use App\Repositories\House\HouseRepositoryInterface;
use App\Services\FileService;

class HouseController extends Controller
{
    /**
     * @param HouseRepositoryInterface $houseRepository
     * @param FileService $fileService
     */
    public function __construct(
        public HouseRepositoryInterface $houseRepository,
        public FileService $fileService,
    )
    {
    }

    /**
     * @param HouseRequest $request
     * @return RedirectResponse
     */
    public function create(HouseRequest $request): RedirectResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function detail(Request $request): JsonResponse
    {
        $data = $request->all()['data'];
        $house = $this->houseRepository->find($data['id']);

        return response()->json([
            'house'     => $house,
            'errCode'   => 0,
            'message'   => 'Successfully',
        ], 200);
    }

    public function update(HouseRequest $request)
    {
        dd($request);
    }

    public function delete()
    {

    }

    public function updateStatus(Request $request)
    {
        try {
            $house = $this->houseRepository
                ->update(
                    $request->id, [
                        'status' => $request->status ? '0' : '1'
                    ]);

            return response()->json([
                'house'     => $house,
                'errCode'   => 0,
                'message'   => 'Update status successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 1,
                'message' => 'Something went wrong'
            ], 200);
        }
    }
}
