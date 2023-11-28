<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
use App\Constants\CommonConstant;
use App\Http\Requests\LessorRegistrationStep1;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\House\HouseRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class LessorController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param AddressService $addressService
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public HouseRepositoryInterface $houseRepository,
    )
    {
    }

    /**
     * @return Response
     */
    public function register(): Response
    {
        return Inertia::render('Client/LessorRegistration/Index');
    }

    public function registerStep1(LessorRegistrationStep1 $request)
    {
    }
    public function dashboard()
    {
        return view('lessor.dashboard');
    }

    public function getHouses()
    {
        $houses = $this->houseRepository->all();

        return view('lessor.house.list', [
            'houses' => $houses,
        ]);
    }
}
