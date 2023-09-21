<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Constants\CommonConstants;
use App\Constants\UserConstants;
use App\Constants\KidConstants;
use App\Constants\TeacherInformationConstants;
use App\Constants\TeacherWorkHistoryConstants;
use App\Constants\ReviewConstants;
use App\Constants\ModelHasCategoryConstants;
use App\Constants\CourseApplicationConstants;
use App\Constants\NotificationConstants;
use App\Http\Requests\AccountInfoRequest;
use App\Http\Requests\LearnerInfoRequest;
use App\Http\Requests\OnboardingStep1Request;
use App\Http\Requests\OnboardingStep3Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Kid\KidRepositoryInterface;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\ModelHasCategory\ModelHasCategoryRepositoryInterface;
use App\Repositories\TeacherInformation\TeacherInformationRepositoryInterface;
use App\Repositories\TeacherWorkHistory\TeacherWorkHistoryRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\CourseApplication\CourseApplicationRepositoryInterface;
use App\Services\MailService;
use App\Services\FileService;
use App\Services\NotificationService;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var kidRepository
     */
    protected $kidRepository;

    /**
     * @var mailService
     */
    protected $mailService;

    /**
     * @var fileService
     */
    protected $fileService;

    /**
     * @var teacherInforRepository
     */
    protected $teacherInforRepository;

    /**
     * @var teacherWorkHistoryRepository
     */
    protected $teacherWorkHistoryRepository;

    /**
     * @var LessonRepositoryInterface
     */
    protected $lessonCourseRepository;

    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @var modelHasCategoryRepository
     */
    protected $modelHasCategoryRepository;

    /**
     * @var reviewRepository
     *
     */
    protected $reviewRepository;

    /**
     * @var courseApplicationRepository
     *
     */
    protected $courseApplicationRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param KidRepositoryInterface $kidRepository
     * @param MailService $mailService
     * @param FileService $fileService
     * @param TeacherInformationRepositoryInterface $teacherInforRepository
     * @param TeacherWorkHistoryRepositoryInterface $teacherWorkHistoryRepository
     * @param LessonCourseRepositoryInterface $lessonCourseRepository
     * @param LessonRepositoryInterface $lessonCourseRepository
     * @param ModelHasCategoryRepositoryInterface $modelHasCategoryRepository
     * @param ReviewRepositoryInterface $reviewRepository
     * @param CourseApplicationRepositoryInterface $courseApplicationRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        KidRepositoryInterface $kidRepository,
        MailService $mailService,
        FileService $fileService,
        TeacherInformationRepositoryInterface $teacherInforRepository,
        TeacherWorkHistoryRepositoryInterface $teacherWorkHistoryRepository,
        LessonCourseRepositoryInterface $lessonCourseRepository,
        LessonRepositoryInterface $lessonRepository,
        ModelHasCategoryRepositoryInterface $modelHasCategoryRepository,
        ReviewRepositoryInterface $reviewRepository,
        CourseApplicationRepositoryInterface $courseApplicationRepository,
        public NotificationService $notificationService,
    ) {
        $this->userRepository               = $userRepository;
        $this->kidRepository                = $kidRepository;
        $this->mailService                  = $mailService;
        $this->fileService                  = $fileService;
        $this->teacherInforRepository       = $teacherInforRepository;
        $this->teacherWorkHistoryRepository = $teacherWorkHistoryRepository;
        $this->lessonCourseRepository       = $lessonCourseRepository;
        $this->lessonRepository             = $lessonRepository;
        $this->modelHasCategoryRepository   = $modelHasCategoryRepository;
        $this->reviewRepository             = $reviewRepository;
        $this->courseApplicationRepository  = $courseApplicationRepository;
    }

    /**
     * @Route get("/information", name="user.information")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function information(Request $request): RedirectResponse|Response
    {
        if (!$token = $request->token) :
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid Token');
        endif;

        if (! $user = $this->userRepository->findOneBy(
            [UserConstants::COL_REMEMBER_TOKEN => $token],
        )):
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid Token');
        endif;

        $user->year = $user->birthday ? date("Y", strtotime($user->birthday)) : null;
        $user->month = $user->birthday ? date("m", strtotime($user->birthday)) : null;
        $user->day = $user->birthday ? date("d", strtotime($user->birthday)) : null;
        $user->country = $user->country;
        $user->city = $user->city;
        foreach ($user->kids as $kid):
            $kid->year = $kid->birthdayOrigin ? date("Y", strtotime($kid->birthdayOrigin)) : null;
            $kid->month = $kid->birthdayOrigin ? date("m", strtotime($kid->birthdayOrigin)) : null;
            $kid->day = $kid->birthdayOrigin ? date("d", strtotime($kid->birthdayOrigin)) : null;
            $kid->categories = $this->modelHasCategoryRepository->getAllCategoryOfKid($kid->id);
        endforeach;

        return Inertia::render('Auth/Information/Index', [
            'token' => $token,
            'user'  => $user,
        ]);
    }

    /**
     * @Route post("/information/account-info", name="account.info")
     * @param AccountInfoRequest $request
     * @return void
     */
    public function createAccountInfo(AccountInfoRequest $request)
    {
        if (!$token = $request->params['token']) :
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid Token');
        endif;

        try {
            if (! $user = $this->userRepository->findBy([
                    UserConstants::COL_REMEMBER_TOKEN => $token
                ])->first()
            ) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            endif;

            if (! $user_update = $this->userRepository
                    ->update(
                        $user->id,
                        [
                            UserConstants::COL_NICK_NAME            => $request->nickName,
                            UserConstants::COL_FIRST_NAME           => $request->firstName,
                            UserConstants::COL_FIRST_NAME_KANA      => $request->firstNameKana,
                            UserConstants::COL_LAST_NAME            => $request->lastName,
                            UserConstants::COL_LAST_NAME_KANA       => $request->lastNameKana,
                            UserConstants::COL_BIRTHDAY             => Carbon::parse($request->birthday)->format(CommonConstants::DATE_FORMAT_YMD),
                            UserConstants::COL_COUNTRY_ID           => $request->country['id'] ?? null,
                            UserConstants::COL_CITY_ID              => $request->city['id'] ?? null,
                            UserConstants::COL_EMAIL_VERIFIED_AT    => Carbon::now(),
                            UserConstants::COL_STATUS               => UserConstants::INFORMATION_INCOMPLETE,
                        ]
                    )
            ) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::MSG, __('messages.common.invalid'));
            endif;
        } catch (\Throwable $th) {
            return redirect()
                ->route('top')
                ->with(CommonConstants::MSG, __('messages.common.invalid'));
        }
    }

    /**
     * @Route get("/information/learner-info", name="learner.info")
     * @param LearnerInfoRequest $request
     * @return void
     */
    public function createLearnerInfo(LearnerInfoRequest $request)
    {
        try {
            if (! $token = $request->params['token']) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            endif;
            if (! $user = $this->userRepository->findBy([
                    UserConstants::COL_REMEMBER_TOKEN => $token
                ])->first()
            ) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            endif;

            // if (! $kid = $this->kidRepository
            //     ->createKidInformation($user->id, $request->all())
            //     ) :
            //     return redirect()
            //         ->route('top')
            //         ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            // endif;

        } catch (\Throwable $th) {
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid Token');
        }
    }

    /**
     * @Route get("/information/completed`", name="completed.info")
     * @param Request $request
     * @return RedirectResponse
     */
    public function completed(Request $request): RedirectResponse
    {
        $credentials = [];

        if ($token = $request->params['token']) :
            $credentials = [
                UserConstants::COL_REMEMBER_TOKEN => $token
            ];
        else :
            $credentials = [
                UserConstants::COL_EMAIL            => session()->get(UserConstants::COL_EMAIL),
                UserConstants::COL_REMEMBER_TOKEN   => session()->get(UserConstants::COL_REMEMBER_TOKEN)
            ];
        endif;


        if ($user = $this->userRepository->findBy($credentials)->first()) :
            //create kids
            if ($request->kids && ! $kid = $this->kidRepository->createKidInformation($user->id, $request->all())):
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            endif;

            if (auth()->loginUsingId($user->id)) :
                Log::info('login credentials');
                $user = auth()->user();
                $data['url'] = 'https://dottrees.hatoq.com/';
                $data['first_name'] = $user->first_name ?? '';
                $data['last_name'] = $user->last_name ?? '';
                $send_mail  = $this->mailService->sendMailInformationRegister($user, $data);
                $this->userRepository->update($user->id, [
                    UserConstants::COL_STATUS => UserConstants::INFORMATION_COMPLETED,
                ]);

                if (session()->has('url.intended')):
                    return redirect(session()->pull('url.intended'));
                endif;

                return redirect()->route('success.info')->with([
                    'email' => session()->get(UserConstants::COL_EMAIL),
                    'token' => $credentials[UserConstants::COL_REMEMBER_TOKEN],
                ]);
            endif;
        endif;

        throw ValidationException::withMessages([
            CommonConstants::ERR_MSG => trans('messages.login.EM-001'),
        ]);
    }

    /**
     * @Route get("/teacher/registration", name="teacher.registration")
     * @param Request $request
     * @return RedirectResponse
     */
    public function teacherRegistration(Request $request): RedirectResponse
    {
        try {
            $token = $request->token ?? '';

            if (! $user = $this->userRepository->findBy([
                    UserConstants::COL_REMEMBER_TOKEN => $token
                ])->first()
            ) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid');
            endif;

            if (! $this->userRepository->update($user->id, [
                UserConstants::COL_ROLE => UserConstants::ROLE_TEACHER,
                UserConstants::COL_VERIFY_TEACHER => UserConstants::REQUEST_VERIFIED,
            ])) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid');
            endif;

            return redirect()
                    ->route('teacher.dashboard')
                    ->with(CommonConstants::MSG, 'Success');
        } catch (\Throwable $th) {
            return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid');
        }
    }

    /**
     * @Route get("information/success" , name="success.info")
     * @return Response
     */
    public function createInfoSuccess(): Response
    {
        return Inertia::render('Auth/Information/Completed', [
            'email' => session()->get(UserConstants::COL_EMAIL),
            'token' => session()->get('token'),
        ]);
    }

    /**
     * @Route get('/become-teacher', name = 'show.form.become-teacher')
     * @return Response
     *
     * When user click to humbeger icon and choose "become teacher", this function called
     */
    public function showFormBecomeTeacher(): Response
    {
        return Inertia::render('Auth/Information/Completed', [
            'email' => auth()->user()[UserConstants::COL_EMAIL],
            'token' => auth()->user()[UserConstants::COL_REMEMBER_TOKEN],
        ]);
    }

    /**
     * @Route get('/switch-user-teacher', name = 'switch.user.teacher');
     * @return RedirectResponse
     *
     * When user verifed to become teacher, and click to humbeger icon + choose "switch to user/teacher", this function called
     */
    public function switchBetweenUserAndTeacher(): RedirectResponse
    {
        try {
            $user = auth()->user();
            if ($user && $user->verify_teacher == UserConstants::REQUEST_VERIFIED):
                if ($user[UserConstants::COL_ROLE] == UserConstants::ROLE_PARENT):
                    $this->userRepository->update($user->id, [
                        UserConstants::COL_ROLE => UserConstants::ROLE_TEACHER,
                    ]);
                    auth()->user()->fresh();

                    return redirect()
                        ->route('teacher.dashboard')
                        ->with(CommonConstants::MSG, 'Success');
                elseif ($user[UserConstants::COL_ROLE] == UserConstants::ROLE_TEACHER):
                    $this->userRepository->update($user->id, [
                        UserConstants::COL_ROLE => UserConstants::ROLE_PARENT,
                    ]);
                    auth()->user()->fresh();

                    return redirect()
                        ->route('top')
                        ->with(CommonConstants::MSG, 'Success');
                endif;
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid');
            endif;
        } catch (\Throwable $th) {
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid');
        }
    }

    /**
     * @Route get("/onboarding", name="onboarding.index")
     * @return Response
     */
    public function onboardingView(): Response
    {
        $teacherInformation = $this->teacherInforRepository->findOneBy([
            TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
        ]);

        if ($teacherInformation) :
            $teacherInformation->year   = date("Y", strtotime($teacherInformation->birthday));
            $teacherInformation->month  = date("m", strtotime($teacherInformation->birthday));
            $teacherInformation->day    = date("d", strtotime($teacherInformation->birthday));
            $teacherInformation->admission_year     = $teacherInformation->admission_date
                ? date("Y", strtotime($teacherInformation->admission_date))
                : null;
            $teacherInformation->admission_month    = $teacherInformation->admission_date
                ? date("d", strtotime($teacherInformation->admission_date))
                : null;
            $teacherInformation->graduation_year    = $teacherInformation->graduation_date
                ? date("Y", strtotime($teacherInformation->graduation_date))
                : null;
            $teacherInformation->graduation_month   = $teacherInformation->graduation_date
                ? date("d", strtotime($teacherInformation->graduation_date))
                : null;
        endif;

        $teacherWorkHistories = $this->teacherWorkHistoryRepository->findBy([
            TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
        ]);

        $user = auth()->user();

        if ($user) :
            $user->year   = date("Y", strtotime($user->birthday));
            $user->month  = date("m", strtotime($user->birthday));
            $user->day    = date("d", strtotime($user->birthday));
        endif;

        $stepIntent = session()->has('onboarding_teacher.step_intent') ?
            session()->pull('onboarding_teacher.step_intent') :
            TeacherInformationConstants::SCREEN_STEP_LIST;

        return Inertia::render('User/BecomeTeacher', [
            'teacherInformation'    => $teacherInformation,
            'teacherWorkHistories'  => $teacherWorkHistories,
            'user'                  => $user,
            'step'                  => $stepIntent,
        ]);
    }

    /**
     * @Route post("/onboarding/step1" name="onboarding.create.step1")
     * @param OnboardingStep1Request $request
     * @return void
     */
    public function createInforTeacherStep1(OnboardingStep1Request $request)
    {
        if (strlen($request->email) > mb_strlen($request->email, 'utf8')) :
            throw ValidationException::withMessages([
                'email' => 'Email は半角英数字に入力してください',
            ]);
        endif;

        try {
            $domain = request()->getSchemeAndHttpHost();
            $profileImage = '';
            $introductionVideo = '';

            if ($request->hasFile('profile_image')) :
                $profileImage = $this->fileService
                    ->storeFile(
                        $request->profile_image,
                        TeacherInformationConstants::STORAGE_PROFILE_IMAGE
                    );
            else:
                $profileImage = $request->profile_image;
            endif;

            if ($request->hasFile('short_video_for_learner')) :
                $introductionVideo = $this->fileService
                    ->storeFile(
                        $request->short_video_for_learner,
                        TeacherInformationConstants::STORAGE_INTRODUCTION_VIDEO
                    );
            endif;

            $dataUser = [
                UserConstants::COL_FIRST_NAME             => $request->first_name,
                UserConstants::COL_LAST_NAME              => $request->last_name,
                UserConstants::COL_FIRST_NAME_KANA        => $request->first_name_kana ?? null,
                UserConstants::COL_LAST_NAME_KANA         => $request->last_name_kana ?? null,
                UserConstants::COL_COUNTRY_ID             => $request->country_id,
                UserConstants::COL_CITY_ID                => $request->city_id,
                // UserConstants::COL_EMAIL                  => $request->email,
                UserConstants::COL_BIRTHDAY
                    => convertStringToDate($request->year, $request->month, $request->day),
            ];

            $data = [
                TeacherInformationConstants::COL_TEACHER_ID             => auth()->user()->id,
                TeacherInformationConstants::COL_PROFILE_IMAGE          => $domain . '/' . $profileImage,
                TeacherInformationConstants::COL_COUNTRY_CODE           => substr($request->country_code, -3),
                TeacherInformationConstants::COL_PHONE                  => $request->phone,
                TeacherInformationConstants::COL_JOB                    => $request->job,
                TeacherInformationConstants::COL_SALARY                 => $request->salary,
                TeacherInformationConstants::COL_HEADLINE               => $request->headline,
                TeacherInformationConstants::COL_ABOUT                  => $request->about,
                TeacherInformationConstants::COL_INTRODUCTION_VIDEO     => $domain . '/' . $introductionVideo,
                // TeacherInformationConstants::COL_STEP                   => 1,
            ];

            $user = $this->userRepository->update(auth()->user()->id, $dataUser);

            if ($teacherInformation = $this->teacherInforRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ])) {
                $teacherInformation = $this->teacherInforRepository->update($teacherInformation->id, $data);
            } else {
                $teacherInformation = $this->teacherInforRepository->create($data);
            }

            return app('App\Http\Controllers\StripeController')->createOrUpdateStripeAccountStep1($teacherInformation, $user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @Route post("/onboarding/step1-confirm" name="onboarding.confirm.step1")
     * @param OnboardingStep1Request $request
     * @return void
     */
    public function confirmInforTeacherStep1(OnboardingStep1Request $request)
    {
        try {
            if (! $teacherInformation = $this->teacherInforRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ])):
                return redirect()
                    ->route('onboarding.index')
                    ->with(CommonConstants::ERR_MSG, 'Invalid');
            endif;

            $teacherInformation = $this->teacherInforRepository->update($teacherInformation->id, [
                TeacherInformationConstants::COL_STEP  => 1,
            ]);

            return response('', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @Route post("/onboarding/step3" name="onboarding.create.step3")
     * @param OnboardingStep3Request $request
     * @return void
     */
    public function createInforTeacherStep3(OnboardingStep3Request $request)
    {
        try {
            if ($request->step) :
                $domain = request()->getSchemeAndHttpHost();
                $academicCertificate = '';
                if ($request->academic_certificate) :
                    $academicCertificate = $this->fileService
                    ->storeFile(
                        $request->academic_certificate,
                        TeacherInformationConstants::STORAGE_CERTIFICATE_IMAGE
                    );
                endif;

                $dataInfor = [
                    TeacherInformationConstants::COL_STEP               => 3,
                    TeacherInformationConstants::COL_SCHOOL             => $request->school,
                    TeacherInformationConstants::COL_MAJOR              => $request->major,
                    TeacherInformationConstants::COL_MAJOR_SPECIALIZE   => $request->major_specialize,
                    TeacherInformationConstants::COL_ADMISSION_DATE
                        => formatDateYm($request->admission_year, $request->admission_month),
                    TeacherInformationConstants::COL_GRADUATION_DATE
                        => formatDateYm($request->graduation_year, $request->graduation_month),
                    TeacherInformationConstants::COL_ACADEMIC_CERTIFICATE
                        => $domain . '/' . $academicCertificate,
                ];

                if ($teacherInformation = $this->teacherInforRepository->findOneBy([
                    TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
                ])) {
                    $this->teacherInforRepository->update($teacherInformation->id, $dataInfor);
                }

                $this->teacherWorkHistoryRepository
                    ->deleteByAttr(
                        TeacherWorkHistoryConstants::COL_TEACHER_ID,
                        auth()->user()->id
                    );

                foreach ($request->work_histories as $item) :
                    $dataWork = [
                        TeacherWorkHistoryConstants::COL_TEACHER_ID
                            => auth()->user()->id,
                        TeacherWorkHistoryConstants::COL_WORK_POSITION
                            => $item[TeacherWorkHistoryConstants::COL_WORK_POSITION],
                        TeacherWorkHistoryConstants::COL_RECRUITMENT
                            => $item[TeacherWorkHistoryConstants::COL_RECRUITMENT],
                        TeacherWorkHistoryConstants::COL_COMPANY
                            => $item[TeacherWorkHistoryConstants::COL_COMPANY],
                        TeacherWorkHistoryConstants::COL_WORK_START_DATE
                            => formatDateYm($item['work_start_year'], $item['work_start_month']),
                        TeacherWorkHistoryConstants::COL_WORK_END_DATE
                            => formatDateYm($item['work_end_year'], $item['work_end_month']) ?? '',
                        TeacherWorkHistoryConstants::COL_IS_STILL_WORKING
                            => $item['work_end_year'] && $item['work_end_month'] ? '1' : '0',
                    ];
                    $this->teacherWorkHistoryRepository->create($dataWork);
                endforeach;

                $this->userRepository->update(auth()->user()->id, [
                    UserConstants::COL_VERIFY_TEACHER   => UserConstants::REQUEST_VERIFYING,
                ]);
            endif;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @Route get("/history")
     * @return Response
     */
    public function getListHistory(): Response
    {
        $courseApplied = [];
        $courses = $this->lessonCourseRepository->all();
        foreach ($courses as $course):
            $lesson = $this->lessonRepository->find($course->lesson_id);

            foreach ($course->course_schedules as $schedule) :
                $schedule['compare'] =  Carbon::parse($schedule['date']." ".Carbon::parse($schedule['end_time'])->format('H:i:s'));
            endforeach;
            $sortDate = collect($course->course_schedules)->sortBy('date')->all();

            if (count($sortDate)) :
                $lastSchedule = array_values($sortDate)[count($sortDate) - 1]->compare;
                if ($lastSchedule < Carbon::now()):
                    foreach ($course->course_applications as $courseApplication):
                        if ($courseApplication->user_id === auth()->user()->id && $courseApplication->status === '1'):
                            $course['group_date'] = Carbon::parse($courseApplication->created_at)->format('Y/m/d');
                            $course['lesson'] = $lesson;
                            $courseApplied[] = $course;
                        endif;
                    endforeach;
                endif;
            else :
                continue;
            endif;
        endforeach;
        $sortDate = collect($courseApplied)->sortBy('group_date', true)->all();
        $listScheduleSorted = array_values($sortDate);
        $courseAppliedGroupBy = collect(array_unique($listScheduleSorted))->groupBy('group_date')->toArray();

        return Inertia::render('User/History', [
            'course_applied' => $courseAppliedGroupBy
        ]);
    }

    /**
     * @Route get("/review/{id}")
     * @return Response
     */
    public function getCourseReview($id): Response
    {
        $lessonReviews = $this->reviewRepository->findBy([
            ReviewConstants::COL_USER_ID => auth()->user()->id,
            ReviewConstants::COL_LESSON_ID => $id,
        ]);
        $lesson = $this->lessonRepository->find($id);

        return Inertia::render('User/Review', [
            'lesson_reviews' => $lessonReviews,
            'lesson' => $lesson,
        ]);
    }

    /**
     * @Route get("/review-form/{id}")
     * @return Response
     */
    public function getFormReview($id): Response
    {
        $lesson = $this->lessonRepository->find($id);

        return Inertia::render('User/ReviewForm', [
            'lesson' => $lesson,
            'user' => auth()->user(),
        ]);
    }

    /**
     * @Route post("/review-form/{id}")
     * @param ReviewRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function createReview(Request $request, $id): RedirectResponse
    {
        try {
            $lesson = $this->lessonRepository->find($id);
            DB::transaction(function () use ($request, $id, $lesson) {
                $newReview = $this->reviewRepository->create([
                    ReviewConstants::COL_LESSON_ID          => $id,
                    ReviewConstants::COL_USER_ID            => auth()->user()->id,
                    ReviewConstants::COL_REVIEW             => $request->review,
                    ReviewConstants::COL_RATE               => 0,
                    ReviewConstants::COL_EASE_OF_UNDERSTANDING   => $request->easeOfUnderstanding ? $request->easeOfUnderstanding : null,
                    ReviewConstants::COL_BENEFICIAL         => $request->beneficial ? $request->beneficial : null,
                    ReviewConstants::COL_GOOD_AT_TEACHING   => $request->goodAtTeaching ? $request->goodAtTeaching : null,
                    ReviewConstants::COL_ENJOYABLE          => $request->enjoyable ? $request->enjoyable : null,
                ]);
                if ($lesson->teacher) :
                    $this->notificationService->sendNotification(
                        $lesson->teacher,
                        [
                            'title'     => 'レッスン ' . $lesson->title . ' に新しいレビューが届きました。',
                            'target'    => route('schedule.review', [$id => $newReview->id]),
                        ],
                        NotificationConstants::BROADCAST_TEACHER,
                    );
                endif;
            });
            DB::commit();

            return redirect()
                ->route('create.review.success', ['id' => $id])
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route get(/review-success/{id}")
     * @param int $id
     * @return Response
     */
    public function createReviewSuccess($id): Response
    {
        return Inertia::render('User/ReviewSuccess', [
            'lesson_id' => $id,
        ]);
    }

    /**
     * @Route get(/account")
     * @return Response
     */
    public function account(): Response
    {
        $user = auth()->user();
        $userCategories = $this->modelHasCategoryRepository->findBy([
            ModelHasCategoryConstants::COL_MODEL_ID     => $user->id,
            ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_USER,
        ]);
        if (count($userCategories)):
            $user->category = $userCategories;
        else :
            $user->category = null;
        endif;
        foreach ($user->kids as $kid):
            $kidCategories = $this->modelHasCategoryRepository->findBy([
                ModelHasCategoryConstants::COL_MODEL_ID     => $kid->id,
                ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_KID,
            ]);
            if (count($kidCategories)):
                $kid->category = $kidCategories;
            else :
                $kid->category =  null;
            endif;

            $kid->origin_birthday =  $kid->birthdayOrigin;
        endforeach;

        return Inertia::render('User/Account', [
            'user' => $user,
        ]);
    }

    /**
     * @Route post("/kid-delete")
     * @param KidRequest $request
     * @return RedirectResponse
     */
    public function deleteKid(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $kidDelete = $this->kidRepository->delete($request['delete_kid']['id']);
            });

            DB::commit();

            return redirect()
                ->route('user.account')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route post("/kid-update")
     * @param KidRequest $request
     * @return RedirectResponse
     */
    public function updateKid(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request['id']) :
                    $updateKid = $this->kidRepository->update($request['id'], [
                        KidConstants::COL_NICK_NAME     => $request['nickName'],
                        KidConstants::COL_FIRST_NAME    => $request['firstName'],
                        KidConstants::COL_LAST_NAME     => $request['lastName'],
                        KidConstants::COL_BIRTHDAY      => Carbon::parse($request['year'].$request['month'].$request['day']),
                    ]);
                else :
                    $updateKid = $this->kidRepository->create([
                        KidConstants::COL_PARENT_ID     => auth()->user()->id,
                        KidConstants::COL_NICK_NAME     => $request['nickName'],
                        KidConstants::COL_FIRST_NAME    => $request['firstName'],
                        KidConstants::COL_LAST_NAME     => $request['lastName'],
                        KidConstants::COL_BIRTHDAY      => Carbon::parse($request['year'].$request['month'].$request['day']),
                    ]);
                endif;

                $userCategories = $this->modelHasCategoryRepository->findBy([
                    ModelHasCategoryConstants::COL_MODEL_TYPE => ModelHasCategoryConstants::MODEL_KID,
                    ModelHasCategoryConstants::COL_MODEL_ID   => $updateKid->id,
                ]);
                foreach ($userCategories as $userCategory) :
                    $deleteUserCategory = $this->modelHasCategoryRepository->delete($userCategory->id);
                endforeach;

                foreach ($request->interest as $category) :
                    $deleteUserCategory = $this->modelHasCategoryRepository->create([
                        ModelHasCategoryConstants::COL_MODEL_TYPE => ModelHasCategoryConstants::MODEL_KID,
                        ModelHasCategoryConstants::COL_MODEL_ID   => $updateKid->id,
                        ModelHasCategoryConstants::COL_CATEGORY_ID   => $category,
                    ]);
                endforeach;
            });
            DB::commit();

            return redirect()
                ->route('user.account')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route post("/parent-update")
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function updateParent(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $userCategories = $this->modelHasCategoryRepository->findBy([
                    ModelHasCategoryConstants::COL_MODEL_TYPE => ModelHasCategoryConstants::MODEL_USER,
                    ModelHasCategoryConstants::COL_MODEL_ID   => auth()->user()->id,
                ]);
                foreach ($userCategories as $userCategory) :
                    $deleteUserCategory = $this->modelHasCategoryRepository->delete($userCategory->id);
                endforeach;

                foreach ($request->interest as $category) :
                    $deleteUserCategory = $this->modelHasCategoryRepository->create([
                        ModelHasCategoryConstants::COL_MODEL_TYPE => ModelHasCategoryConstants::MODEL_USER,
                        ModelHasCategoryConstants::COL_MODEL_ID   => auth()->user()->id,
                        ModelHasCategoryConstants::COL_CATEGORY_ID   => $category,
                    ]);
                endforeach;

                $parentUpdate = $this->userRepository->update($request['id'], [
                    UserConstants::COL_COUNTRY_ID       => $request['country'],
                    UserConstants::COL_CITY_ID          => $request['city'],
                    UserConstants::COL_NICK_NAME        => $request['nickName'],
                    UserConstants::COL_FIRST_NAME       => $request['firstName'],
                    UserConstants::COL_LAST_NAME        => $request['lastName'],
                    UserConstants::COL_FIRST_NAME_KANA  => $request['firstNameKatakana'],
                    UserConstants::COL_LAST_NAME_KANA   => $request['lastNameKatakana'],
                    UserConstants::COL_BIRTHDAY         => Carbon::parse($request['year'].$request['month'].$request['day']),
                ]);
            });
            DB::commit();

            return redirect()
                ->route('user.account')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route post("/account-delete")
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        $courseApplications = $this->courseApplicationRepository->findBy([
            CourseApplicationConstants::COL_USER_ID => $request['user']['id']
        ]);
        if (count($courseApplications)) :
            $invalidCourseTitles = [];
            foreach($courseApplications as $courseApplication) :
                if ($courseApplication->status == '1') :
                    $course = $this->lessonCourseRepository->find($courseApplication->course_id);
                    $invalidCourseTitles[] = $course->title;
                endif;
            endforeach;
            if ($invalidCourseTitles) : 
                $invalidTitles = join(", ",$invalidCourseTitles);
                throw ValidationException::withMessages([
                    'message' => "この｛$invalidTitles} を予約していますので、アカウントを削除できません。",
                ]);
            endif;
        endif;
        try {
            DB::transaction(function () use ($request) {
                $accountDelete = $this->userRepository->delete($request['user']['id']);
            });
            DB::commit();

            session()->flush();
            auth()->logout();

            return redirect()
                ->route('delete.account.success');
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route get("/delete-success")
     * @return Response
     */
    public function deleteSuccess(): Response
    {
        return Inertia::render('User/AccountDeleteNoti');
    }

    public function getNotification()
    {
        return Inertia::render('User/Notification', [
            'user_role' => auth()->user()->role
        ]);
    }
}
