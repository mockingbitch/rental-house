<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
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
        $listHouse = [];
        $house = [
            'cover_image' => 'https://www.forbes.com/home-improvement/wp-content/uploads/2022/07/download-23.jpg',
            'title' => 'Vjpro luxury',
            'lessor' => [
                'first_name' => 'Phong',
                'last_name' => 'Trần',
            ],
            'price' => 1600000,
            'min_capacity' => 1,
            'max_capacity' => 5,
        ];
        $objHouse = (object) $house;
        $listHouse[] = $objHouse;

        return Inertia::render('Client/Top', [
            'houses' => $listHouse,
        ]);
    }
}
