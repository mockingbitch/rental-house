<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UserInfoRequest;
use App\Repositories\User\UserRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
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
            ->findByAttrFirst('remember_token', $request->token);

        return Inertia::render('Auth/AccountInformation/Index', [
            'user' => $user,
        ]);
    }

    /**
     * @Route post("/user-information" name="account.info")
     * @param UserRequest $request
     */
    public function updateUserInformation(UserInfoRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository
            ->findByAttrFirst('remember_token', $data['params']['token']);
        try {
            $user->update($data);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'error' => trans('messages.register.EM-001'),
            ]);
        }
    }
}
