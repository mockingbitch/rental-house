<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
//use App\Constants\CommonConstant;
use App\Http\Requests\LessorRegistrationStep1;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\House\HouseRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class LessorController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param HouseRepositoryInterface $houseRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public HouseRepositoryInterface $houseRepository,
        public CategoryRepositoryInterface $categoryRepository,
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

    /**
     * @return View
     */
    public function dashboard(): View
    {
        return view('lessor.dashboard');
    }

    /**
     * @return View
     */
    public function getHouses(): View
    {
        $houses = $this->houseRepository->all();
        $category = $this->categoryRepository->all();

        return view('lessor.house.list', [
            'houses'        => $houses,
            'category'      => $category,
            'breadcrumb'    => 'House',
        ]);
    }
}
