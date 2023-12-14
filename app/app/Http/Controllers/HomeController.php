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
    )
    {

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
        $listHouse = $this->houseRepository
            ->getAllWithRelationShip(['lessor', 'rooms']);

        return Inertia::render('Client/Top', [
            'houses' => $listHouse,
        ]);
    }
}
