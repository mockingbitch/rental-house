<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
use App\Constants\CommonConstant;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use Inertia\Inertia;
use Inertia\Response;

class LessorController extends Controller
{
    /**
     * @param FileService $fileService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        public FileService $fileService,
        public UserRepositoryInterface $userRepository,
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
}
