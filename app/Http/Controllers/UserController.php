<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

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

    public function userInformation(Request $request)
    {
        $user = $this->userRepository->findByAttrFirst('remember_token', $request->token);

        return Inertia::render('Auth/AccountInformation/Index', [
            'user' => $user,
        ]);
    }

    /**
     *@Route post("/user-information" name="account.info")
     *@param UserRequest $request
     */
    public function updateUserInformation(UserInfoRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository->findByAttrFirst('remember_token', $data['params']['token']);
        try {
            $user->update($data);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'error' => trans('messages.register.EM-001'),
            ]);
        }
    }
}
