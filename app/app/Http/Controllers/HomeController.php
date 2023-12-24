<?php

namespace App\Http\Controllers;

use App\Repositories\House\HouseRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        public HouseRepositoryInterface $houseRepository,
    ) {
    }

    public function adminDashboard()
    {
        return view('dashboard');
    }

    /**
     * @Route get("/", name="top")
     *
     * @return Response
     */
    public function index(): Response
    {
        if (auth()->user() && auth()->user()->province_code) :
            $listSuggested = $this->houseRepository
                ->findByWithRelationShip(
                    ['lessor', 'rooms'],
                    ['province_code' => auth()->user()->province_code]
                );
            $restOfList = \App\Models\House::where(
                'province_code',
                '<>',
                '003'
            )->get();
            $listHouse = $listSuggested->merge($restOfList);
        else :
            $listHouse = $this->houseRepository
                ->getAllWithRelationShip(['lessor', 'rooms']);
        endif;
        foreach ($listHouse as $house) :
            $province = \App\Models\Address\Province::where('code', $house->province_code)->first();
            $district = \App\Models\Address\District::where('code', $house->district_code)->first();
            $ward = \App\Models\Address\Ward::where('code', $house->ward_code)->first();
            if ($province && $district && $ward) :
                $house->full_address = $province->name . '-' . $district->name . '-' . $ward->name;
            endif;
        endforeach;
        return Inertia::render('Client/Top', [
            'houses' => $listHouse,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $listSuggest = [];
        $houses = $this->houseRepository->search($request->all());
        if (count($houses) < 1) :
            $listSuggest = $this->houseRepository
                ->getAllWithRelationship(['rooms', 'lessor']);
        endif;

        return Inertia::render('Client/Search/SearchResult', [
            'houses'        => $houses,
            'listSuggest'   => $listSuggest,
            'dataSearch'    => $request->all(),
        ]);
    }
}
