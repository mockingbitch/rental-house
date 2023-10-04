<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
use App\Http\Requests\UserInfoRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public FileService $fileService,
        )
    {

    }

    /**
     * @Route get("/user-information" name="user.information")
     * @param Request $request
     * @return Response
     */
    public function userInformation(Request $request): Response
    {
        $user = $this->userRepository
            ->findByAttrFirst(
                UserConstant::COL_REMEMBER_TOKEN,
                $request->token
            );

        return Inertia::render('Auth/AccountInformation/Index', [
            'user' => $user,
        ]);
    }

    /**
     * @Route post("/user-information" name="account.info")
     * @param UserRequest $request
     * @throws ValidationException
     */
    public function updateUserInformation(UserInfoRequest $request)
    {
        $data = $request->all();
        try {
            $user = $this->userRepository
                ->findByAttrFirst(
                    UserConstant::COL_REMEMBER_TOKEN,
                    $data['params']['token']
                );
            if ($request->confirm) :
                $data[
                    UserConstant::COL_AVATAR
                    ] = $this->fileService->storeFile(
                        $request->avatar,
                        UserConstant::STORAGE_LINK_AVATAR
                    );
                $user->update($data);
            endif;
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'error' => 'Failed to update',
            ]);
        }
    }
}
