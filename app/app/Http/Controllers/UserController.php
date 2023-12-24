<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
use App\Http\Requests\UserInfoRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use App\Enum\UserEnum;
use App\Http\Requests\UserUpdateByAdminRequest;
use App\Repositories\Ward\WardRepositoryInterface;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param WardRepositoryInterface $wardRepository
     * @param FileService $fileService
     * @param MailService $mailService
     */
    public function __construct(
        public UserRepositoryInterface $userRepository,
        public WardRepositoryInterface $wardRepository,
        public FileService $fileService,
        public MailService $mailService
    ) {
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
     * @param UserInfoRequest $request
     * @throws ValidationException
     */
    public function updateUserInformation(UserInfoRequest $request): void
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
    public function setupUserSuccessfully(): Response
    {
        return Inertia::render('Auth/AccountInformation/SetupSuccessfully');
    }

    /**
     * @Route get("/admin/user-index" name="admin.user.index")
     *
     * @return RedirectResponse|View
     */
    public function userIndex(): RedirectResponse|View
    {
        $user = auth()->user();
        if (! $user):
            return redirect()->route('login.method');
        endif;
        if ($user->role != UserEnum::ROLE_ADMIN->value):
            return redirect()->back();
        endif;

        $users = $this->userRepository->all();
        foreach($users as &$user):
            $user->ward_name = $user->ward?->name_en;
        endforeach;

        $wards = $this->wardRepository->all();

        return view('user.list', [
            'users' => $users,
            'wards' => $wards,
        ]);
    }

    /**
     * @Route post("/admin/user/update" name="admin.user.update")
     * @throws ValidationException
     */
    public function updateUserInfoByAdmin(UserUpdateByAdminRequest $request): JsonResponse
    {
        $data = $request->all();
        try {
            if (array_key_exists(UserConstant::COL_AVATAR, $data) && gettype($data[UserConstant::COL_AVATAR]) == 'object') :
                $data[UserConstant::COL_AVATAR] = $this->fileService->storeFile(
                    $request->avatar,
                    UserConstant::STORAGE_LINK_AVATAR
                );
            endif;

            if (array_key_exists(UserConstant::COL_EMAIL, $data)):
                unset($data[UserConstant::COL_EMAIL]);
            endif;

            $user = $this->userRepository->update(
                $data[UserConstant::COL_ID],
                $data
            );

            if ($user):
                return response()->json([
                    'user' => $user,
                    'errCode' => 0,
                    'message' => 'Update successfully!',
                ], 200);
            else:
                return response()->json([
                    'errCode' => 1,
                    'message' => 'Something went wrong!',
                ], 200);
            endif;
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'error' => 'Failed to update',
            ]);
        }
    }
}
