<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
use App\Http\Requests\UserInfoRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use App\Services\MailService;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param FileService $fileService
     * @param MailService $mailService
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public FileService $fileService,
        public MailService $mailService
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
                if (gettype($data[UserConstant::COL_AVATAR]) !== 'string') :
                    $data[
                        UserConstant::COL_AVATAR
                        ] = $this->fileService->storeFile(
                            $request->avatar,
                            UserConstant::STORAGE_LINK_AVATAR
                        );
                endif;
                $data[UserConstant::COL_EMAIL_VERIFIED_AT] = Carbon::now();
                $data[UserConstant::COL_STATUS] = UserConstant::STT_ACTIVE;
                
                $result = $user->update($data);
                if ($result) :
                    $this->mailService->sendMailSetupSuccessfully($user, $data);
                    auth()->loginUsingId($user->id);
                    Log::info('login credentials');
                endif;
            endif;
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'error' => 'Failed to update',
            ]);
        }
    }

    /**
     * @Route get("/setup-successfully" name="user.setup.success")
     *
     * @return Response
     */
    public function setupUserSuccessfully()
    {
        return Inertia::render('Auth/AccountInformation/SetupSuccessfully');
    }
}
