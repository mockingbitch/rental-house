<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Constants\Constant;
use App\Constants\UserConstant;
//use App\Constants\NotificationConstants;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
//use App\Http\Requests\AccountInfoRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\PasswordResetRepositoryInterface;
use App\Services\MailService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * @param MailService $mailService
     * @param NotificationService $notificationService
     * @param UserRepositoryInterface $userRepository
     * @param PasswordResetRepositoryInterface $passwordResetRepository
     */
    public function __construct(
        public MailService $mailService,
        public NotificationService $notificationService,
        public UserRepositoryInterface $userRepository,
        public PasswordResetRepositoryInterface $passwordResetRepository,
        )
    {
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only(
            UserConstant::COL_EMAIL,
            UserConstant::COL_PASSWORD
        );
        $credentials[UserConstant::COL_VENDOR] = UserConstant::VENDOR_EMAIL;

        if (auth()->attempt($credentials)) :
            Log::info('login credentials');
            if (auth()->user()->email_verified_at === null) :
                return redirect()
                    ->route('register.success')
                    ->with(
                        UserConstant::COL_EMAIL,
                        $credentials[UserConstant::COL_EMAIL]
                    );
            endif;
            if (session()->has('url.intended')):
                return redirect(session()->pull('url.intended'));
            endif;

            return redirect()
                    ->route('top')
                    ->with(Constant::MSG, __('messages.login.SM-001'));
        endif;

        throw ValidationException::withMessages([
            Constant::ERR_MSG => trans('messages.login.EM-001'),
        ]);
    }

    /**
     * @Route get("/login", name="login")
     * @return Response
     */
    public function loginView(): Response
    {
        return Inertia::render('Auth/Login/Login');
    }

    /**
     * @Route get("/login-method", name="login.method")
     * @return Response
     */
    public function loginMethod(): Response
    {
        return Inertia::render('Auth/Login/LoginMethod');
    }

    /**
     * @Route get("/logout", name="logout")
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        session()->flush();
        auth()->logout();

        return redirect()
            ->route('login.method')
            ->with(Constant::MSG, __('messages.logout.SM-001'));
    }

    /**
     * @Route get("/register", name="register")
     * @return Response
     */
    public function registerView(): Response
    {
        return Inertia::render('Auth/Register/Register');
    }

    /**
     * @Route get("/register-method", name="register.method")
     * @return Response
     */
    public function registerMethod(): Response
    {
        return Inertia::render('Auth/Register/RegisterMethod', [
            Constant::MSG => session()->get(Constant::MSG),
        ]);
    }

    /**
     * @Route get("/register-success", name="register.success")
     * @return Response
     */
    public function registerSuccess(): Response
    {
        return Inertia::render('Auth/Register/RegisterSuccess', [
            UserConstant::COL_EMAIL => session()->get(UserConstant::COL_EMAIL)
        ]);
    }

    /**
     * @Route post("/register")
     * @param RegisterRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['vendor']         = UserConstant::VENDOR_EMAIL;
        $data['password']       = Hash::make($request->password);
        $data['remember_token'] = Str::random(60);
        $data['expires_in']     = Carbon::now()->addHour(1);

        try {
            DB::transaction(function () use ($data) {
                $user = $this->userRepository->create($data);
                if ($user) :
                    $this->mailService->sendMail($user, $data);
//                    $user->assignRole('Lessee');
                    // $this->notificationService->sendNotification(
                    //     $user,
                    //     [
                    //         'title'     => 'Welcome to RentalHouse',
                    //         'target'    => route('top'),
                    //     ],
                    //     NotificationConstants::BROADCAST_USER,
                    // );
                endif;
            });
            DB::commit();

            return redirect()
                ->route('register.success')
                ->with([
                    'message'   => __('messages.register.SM-001'),
                    'email'     => $data['email'],
                ]);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();

            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.login.EM-001'),
            ]);
        }
    }

    /**
     * @Route post("/auth/google")
     * @return void
     */
    public function redirectToGoogle()
    {
        session([
            'prev_url' => url()->previous()
        ]);
        $redirectUrl = Socialite::driver(Constant::GOOGLE)
            ->redirect()
            ->getTargetUrl();

        return response('', 409)
            ->header(
                'X-Inertia-Location',
                $redirectUrl
            );
    }

    /**
     * @Route post("/auth/google/callback")
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver(Constant::GOOGLE)->user();
        $existingGoogleUser = $this->userRepository
            ->findUserByEmail($googleUser->email);

        if(
            $existingGoogleUser
            && $existingGoogleUser->email_verified_at !== null
            ) :
            switch (session('prev_url')):
                case route('register.method'):
                    session()->forget('prev_url');

                    return redirect()
                        ->route('register.method')
                        ->with(Constant::MSG, __('messages.register.EM-002'));

                case route('login.method'):
                    session()->forget('prev_url');
                    auth()->login($existingGoogleUser);

                    if (session()->has('url.intended')):
                        return redirect(session()->pull('url.intended'));
                    endif;

                    return redirect()
                        ->route('top')
                        ->with(Constant::MSG, __('messages.login.SM-001'));

                default:
                    session()->forget('prev_url');

                    return redirect()
                        ->route('top')
                        ->with(Constant::MSG, __('messages.login.EM-002'));
            endswitch;
        endif;

        $data = [
            UserConstant::COL_FIRST_NAME       => $googleUser->user[UserConstant::G_DATA_GIVEN_NAME],
            UserConstant::COL_LAST_NAME        => $googleUser->user[UserConstant::G_DATA_FAMILY_NAME],
            UserConstant::COL_EMAIL            => $googleUser->user[UserConstant::G_DATA_EMAIL],
            UserConstant::COL_AVATAR           => $googleUser->user[UserConstant::G_DATA_PICTURE],
            UserConstant::COL_REGION           => $googleUser->user[UserConstant::G_DATA_LOCALE],
            UserConstant::COL_VENDOR           => UserConstant::VENDOR_GOOGLE,
            UserConstant::COL_REMEMBER_TOKEN   => Str::random(60),
            'expires_in'                       => Carbon::now()->addHour(1),
        ];

        try {
            if (
                $existingGoogleUser
                && $existingGoogleUser->email_verified_at == null
                ) :
                $user = $existingGoogleUser;
                $user->update($data);
            else :
                $user = $this->userRepository->create($data);
            endif;
            if ($user) :
                $user->assignRole('Lessee');
                $this->mailService->sendMail($user, $data);
                // $this->notificationService->sendNotification(
                //     $user,
                //     [
                //         'title'     => '新規のアカウント登録ありがとうございます。',
                //         'target'    => route('top'),
                //     ],
                //     NotificationConstants::BROADCAST_USER,
                // );
            endif;

            return redirect()
                ->route('register.success')
                ->with([
                    'message'   => __('messages.register.SM-001'),
                    'email'     => $googleUser->user[UserConstant::G_DATA_EMAIL],
                ]);
        } catch (\Throwable $th) {
            return redirect()
                ->route('register.method')
                ->with(Constant::MSG, __('messages.register.EM-001'));
        }
    }

    /**
     * @Route get("/forgot-password", name="forgot.password")
     * @return Response
     */
    public function forgotPasswordForm(): Response
    {
        return Inertia::render('Auth/ForgotPassword/ForgotPassword');
    }

    /**
     * @Route post("/forgot-password")
     * @return RedirectResponse
     */
    public function sendForgotMail(ForgotPasswordRequest $request): RedirectResponse
    {
        $reset_password_record = $this->passwordResetRepository
            ->findOneBy([
                UserConstant::COL_EMAIL => $request->email
            ]);

        if(!$reset_password_record) :
            $user_token = Str::random(64);
            $data = [
                UserConstant::COL_EMAIL => $request->email,
                Constant::TOKEN => $user_token,
                Constant::COL_CREATED => Carbon::now()
            ];
            $new_reset_password_record = $this->passwordResetRepository->create($data);
            $send_mail = $this->mailService
            ->sendMailResetPassword(
                $request->email,
                $user_token
            );
        endif;

        if($reset_password_record) :
            $send_mail = $this->mailService
                ->sendMailResetPassword(
                    $request->email,
                    $reset_password_record->token
                );
        endif;

        return redirect()
            ->route('forgot.password-pending')
            ->with('email', $request->email);
    }

    /**
     * @Route("/forgot-password-pending", name="forgot-password-pending")
     * @return Response
     */
    public function forgotPasswordPending(): Response
    {
        return Inertia::render('Auth/ForgotPassword/ForgotPasswordPending', [
            UserConstant::COL_EMAIL => session()->get(UserConstant::COL_EMAIL)
        ]);
    }

    /**
     * @Route get("/reset-password-confirm")
     * @return Response
     */
    public function resetPasswordForm(Request $request): Response
    {
        $tokenGet = $request->token;
        $emailGet = $request->email;
        return Inertia::render('Auth/ForgotPassword/ResetPassword', compact('emailGet', 'tokenGet'));
    }

    /**
     * @Route post("/reset-password-confirm")
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $reset_password_record = $this->passwordResetRepository->findOneBy([
            UserConstant::COL_EMAIL => $request->email,
            Constant::TOKEN => $request->token
        ]);

        if(!$reset_password_record) :
            throw ValidationException::withMessages([
                Constant::MSG => __('messages.reset_password.EM-001'),
            ]);
        endif;

        try {
            DB::transaction(function () use ($request) {
                $user_update = $this->userRepository
                    ->updateUserByEmail(
                        $request->email,
                        [UserConstant::COL_PASSWORD => Hash::make($request->password)]
                    );
                $reset_password_delete = $this->passwordResetRepository->deleteByEmail($request->email);
            });
            DB::commit();

            return to_route('reset.password.success')
                ->with(Constant::MSG, __('messages.reset_password.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(Constant::MSG, __('messages.register.EM-001'));
        }
    }

    /**
     * @Route get("/reset-password-success")
     * @return Response
     */
    public function resetPasswordSuccess(Request $request): Response
    {
        return Inertia::render('Auth/ForgotPassword/ResetPasswordSuccess');
    }
}
