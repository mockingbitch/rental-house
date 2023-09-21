<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationDetailConstants;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\CourseApplication\CourseApplicationRepositoryInterface;
use App\Constants\CommonConstants;
use App\Constants\LessonConstants;
use App\Constants\CourseApplicationConstants;
use App\Constants\StripeConstants;
use App\Constants\NotificationConstants;
use App\Models\CourseApplication;
use App\Repositories\ApplicationDetail\ApplicationDetailRepositoryInterface;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\UserSchedule\UserScheduleRepositoryInterface;
use App\Services\MailService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe as StripeGateway;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Inertia\Response;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstants;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Stripe\Account;
use Stripe\Exception\InvalidRequestException;
use App\Repositories\TeacherInformation\TeacherInformationRepositoryInterface;
use App\Constants\TeacherInformationConstants;
use App\Models\TeacherInformation;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class StripeController extends Controller
{
    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var courseApplicationRepository
     */
    protected $courseApplicationRepository;

    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @var lessonCourseRepository
     */
    protected $lessonCourseRepository;

    /**
     * @var applicationDetailRepository
     */
    protected $applicationDetailRepository;

    /**
     * @var mailService
     */
    protected $mailService;

    /**
     * @var stripe
     */
    protected $stripe;

    /**
     * @var userScheduleRepository
     */
    protected $userScheduleRepository;

    /**
     * @var teacherInformationRepository
     */
    protected $teacherInformationRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param PasswordResetRepositoryInterface $passwordResetRepository
     * @param UserScheduleRepositoryInterface $userScheduleRepository
     * @param MailService $mailService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CourseApplicationRepositoryInterface $courseApplicationRepository,
        LessonRepositoryInterface $lessonRepository,
        LessonCourseRepositoryInterface $lessonCourseRepository,
        ApplicationDetailRepositoryInterface $applicationDetailRepository,
        UserScheduleRepositoryInterface $userScheduleRepository,
        MailService $mailService,
        TeacherInformationRepositoryInterface $teacherInformationRepository,
        public NotificationService $notificationService,
    ) {
        $this->userRepository = $userRepository;
        $this->courseApplicationRepository = $courseApplicationRepository;
        $this->lessonRepository = $lessonRepository;
        $this->lessonCourseRepository = $lessonCourseRepository;
        $this->applicationDetailRepository = $applicationDetailRepository;
        $this->teacherInformationRepository = $teacherInformationRepository;
        $this->userScheduleRepository = $userScheduleRepository;
        $this->mailService = $mailService;

        // Connect to Stripe platform account
        if ( !(config('stripe.secret_key') && config('stripe.public_key')) ):
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        endif;
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }

    /**
     * ====================================================================================================================================================
     *                                                        FUNCTIONS BASE
     * ====================================================================================================================================================
     */

    public function calculateTotalPrice(int $kidNumber, int $lessonPrice, int $taxPrecent)
    {
        return $kidNumber * $lessonPrice * (1 + $taxPrecent/100);
    }

    public function calculateApplicationFeeAndTeacherAmount(int $totalPrice, $lessonStyle)
    {
        switch ($lessonStyle):
            case LessonConstants::STYLE_INTERVIEW:
                $teacherRate = 0.7;
                break;
            case LessonConstants::STYLE_PERSONAL:
            default:
                $teacherRate = 0.5;
        endswitch;

        return [
            $totalPrice * (1 - $teacherRate), // applicationFee
            $totalPrice * $teacherRate, // teacherAmount
        ];
    }

    public function courseIsEnoughSeat(int $courseId, int $requiredSeatNumber)
    {
        if (! $course = $this->lessonCourseRepository->find($courseId)):
            return false;
        endif;

        $totalLearnerApplied = 0;
        $courseApplications = $course->course_applications;
        foreach ($courseApplications as $courseApplication):
            if ($courseApplication->status != '1'):
                continue;
            endif;

            $totalLearnerApplied += $courseApplication->application_details->count();
        endforeach;

        if ($totalLearnerApplied + $requiredSeatNumber <= $course->lesson->{LessonConstants::COL_MAX_LEARNER}):
            return true;
        endif;

        return false;
    }
    
    
    /**
     * ==================================================
     *     FUNCTIONS FOR CREATE CONNECTED ACCOUNT
     * ==================================================
     */

    /**
     * Retrieve a Stripe account
     * 
     * @return Account
     */
    public function retrieveAccount(string $accountId): Account
    {
        return $this->stripe->accounts->retrieve($accountId, []);
    }

    /**
     * Return false if account is provided all information and acctepted by Stripe
     * Otherwise return list of document that user need re-provide
     * 
     * @return bool|array
     */
    public function accountMissingInformation(String $accountId): bool|array
    {
        $account = $this->retrieveAccount($accountId);

        return count($account->requirements->currently_due) > 0 ?
            $account->requirements->currently_due:
            false;
    }


    /**
     * Create or update Stripe connected account for candidate
     * Function return url to redirect user to Stripe ui onboarding
     * 
     * @Route post('/become-teacher-form', name = 'show.form.become-teacher')
     * @return Response
     */
    public function createOrUpdateStripeAccountStep1(TeacherInformation $teacherInformation, User $user)
    {
        $dataConfig = [
            'email' => $user->{UserConstants::COL_EMAIL},
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],

            'business_type' => 'individual',
            'business_profile' => [
                'mcc' => StripeConstants::MCC['educational_services'],
                'product_description' => 'Offers online courses for children.',
                'url' => 'https://www.linkedin.com/in/linh-le-70a234213/',
            ],

            'individual' => [
                'first_name_kana' => $user->{UserConstants::COL_FIRST_NAME_KANA},
                'first_name_kanji' => $user->{UserConstants::COL_FIRST_NAME}, //'太郎'
                'last_name_kana' => $user->{UserConstants::COL_LAST_NAME_KANA},
                'last_name_kanji' => $user->{UserConstants::COL_LAST_NAME},
                'dob' => [
                    'day' => date("d", strtotime($user->{UserConstants::COL_BIRTHDAY})),
                    'month' => date("m", strtotime($user->{UserConstants::COL_BIRTHDAY})),
                    'year' => date("Y", strtotime($user->{UserConstants::COL_BIRTHDAY})),
                ],
                'email' => $user->{UserConstants::COL_EMAIL},
                'phone' => $teacherInformation->{TeacherInformationConstants::COL_COUNTRY_CODE} . $teacherInformation->{TeacherInformationConstants::COL_PHONE},
            ],
        ];

        
        try {
            if (! $teacherStripeAccountId = $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID}):
                // create express account
                $newAccount = $this->stripe->accounts->create(array_merge([
                    'type' => 'express',
                    'country' => StripeConstants::COUNTRIES[$user->country_id]['abbr_name'],
                ], $dataConfig));

                //save Stripe account id for teacher
                $teacherInformation = $this->teacherInformationRepository->update($teacherInformation->id, [
                    TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID => $newAccount->id,
                ]);
            else:
                $updatedAccount = $this->stripe->accounts->update($teacherStripeAccountId, $dataConfig);
            endif;

        } catch (\Throwable $th) {
            if ($th instanceof InvalidRequestException):
                switch ($th->getError()->param):
                    case "individual[phone]":
                        $type = 'phone';
                        break;
                    case "individual[dob][year]":
                        $type = 'year';
                        break;
                    case "individual[dob][month]":
                        $type = 'month';
                        break;
                    case "individual[dob][day]":
                        $type = 'day';
                        break;
                    case "individual[first_name_kanji]":
                        $type = 'first_name';
                        break;
                    case "individual[first_name_kana]":
                        $type = 'first_name_kana';
                        break;
                    case "individual[last_name_kanji]":
                        $type = 'last_name';
                        break;
                    case "individual[last_name_kana]":
                        $type = 'last_name_kana';
                        break;
                    case "country":
                        $type = 'country';
                        break;
                    case "email":
                        $type = 'email';
                        break;
                    default:
                        $type = CommonConstants::ERR_MSG;
                endswitch;
                
                throw ValidationException::withMessages([
                    $type => $th->getError()->message,
                ]);
            else:
                dd('can not define error', $th);
            endif;
        }
        
        return response('', 200);
    }

    /**
     * @Route post("/onboarding/step2" name="onboarding.create.step2")
     * @param OnboardingStep1Request $request
     * @return void
     */
    public function createInforTeacherStep2()
    {
        try {
            if (! $teacherInformation = $this->teacherInformationRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ])):
                throw ValidationException::withMessages([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
            endif;

            if ($teacherInformation->{TeacherInformationConstants::COL_STEP} !== 1):
                return redirect()->back();
            endif;

            // if the teacher does not have an stripe account id, go back to step 1 to create it (by setting the value step = null)
            if (! $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID}):
                $this->teacherInformationRepository->update($teacherInformation->{TeacherInformationConstants::COL_ID}, [
                    TeacherInformationConstants::COL_STEP => null,
                ]);

                return redirect()->route('onboarding.index');
            endif;

            if ($this->accountMissingInformation($teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID})):
                $accountLink = $this->stripe->accountLinks->create([
                    'account' => $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID},
                    'refresh_url' => route('onboarding.index'),
                    'return_url' => route('onboarding.stripe.complete'),
                    'type' => 'account_onboarding',
                ]);

                return response('', 409)->header('X-Inertia-Location', $accountLink->url);
            else:
                return redirect()->route('onboarding.stripe.complete');
            endif;
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Return response to redirect to Stripe teacher dashboard
     * 
     * @Route post("/step2-stripe-dashboard" name="onboarding.stripe.checkdashboard")
     * @return Response | RedirectResponse
     */
    public function gotoTeacherStripeDashboard()
    {
        try {
            $teacherInformation = $this->teacherInformationRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ]);

            if (!$teacherInformation 
                || ! $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID}
                || $this->accountMissingInformation($teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID})):
                return redirect()
                    ->route('onboarding.index');
            endif;

            $urlTeacherDashboard = $this->stripe->accounts->createLoginLink(
                $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID},
                []
            );

            return response('', 409)->header('X-Inertia-Location', $urlTeacherDashboard->url);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid');
        }
    }

    /**
     * When user fill-in all information in stripe ui, he/she will redirected back to Dottree, this function called
     * 
     * @Route get('/step2-complete', name = 'onboarding.stripe.complete');
     * @return RedirectResponse
     */
    public function registerStripeAccountComplete()
    {
        try {
            $teacherInformation = $this->teacherInformationRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ]);
            //check status connected account, if there is still information that has not been provided 
            if (!$teacherInformation 
                || ! $teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID}
                || $this->accountMissingInformation($teacherInformation->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID})):
                return redirect()
                    ->route('onboarding.index');
            endif;

            //otherwise, update status of teacher information, redirect to step 5: screen success
            if (! $updatedTeacherInformation = $this->teacherInformationRepository->update($teacherInformation->id, [
                TeacherInformationConstants::COL_STEP => 2,
            ])):
                throw ValidationException::withMessages([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
            endif;

            session(['onboarding_teacher.step_intent' => TeacherInformationConstants::SCREEN_STEP_SUCCESS]);
            
            return redirect()
                    ->route('onboarding.index');
        } catch (\Throwable $th){
            return redirect()
                ->route('top')
                ->with(CommonConstants::ERR_MSG, 'Invalid');
        }
    }

    /**
     * ==================================
     *    FUNCTIONS FOR CREATE PAYMENT
     * ==================================
     */

     /**
     * Return false if account is not accepted to transfer or payout
     * Otherwise return true
     * 
     * @return bool
     */
    public function accountAcceptedForPayment(String $accountId): bool
    {
        $account = $this->retrieveAccount($accountId);

        return $account->charges_enabled && $account->payouts_enabled;
    }

    /**
     * Check if exist uncomplete application, then return payment intent attach with application
     * Otherwise create new application, new payment intent and return.
     *
     * @Route get("payment/initiate")
     * @param Request $request
     * @return Response
     */
    public function initiatePayment(Request $request)
    {
        session(['oldApplyForm' => $request->all()]);
        // Get data
        $lesson = $this->lessonRepository->find($request->lesson['id']);
        $course = $this->lessonCourseRepository->find($request->lessonCourse['id']);
        if (! ($lesson && $course) ):
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        endif;

        $totalPrice = $this->calculateTotalPrice(
            count($request->applyKids),
            $lesson->{LessonConstants::COL_PRICE},
            10
        );
        [$applicationFee, $teacherAmount] = $this->calculateApplicationFeeAndTeacherAmount($totalPrice, $lesson->{LessonConstants::COL_STYLE});

        $learnerQuestions = $request->learnerQuestions;
        $kidIds = array_map(fn ($kid) => $kid['id'], $request->applyKids);

        $teacherConnectedAcountId = $lesson->teacher->teacher_information->{TeacherInformationConstants::COL_STRIPE_ACCOUNT_ID};
        if (! $teacherConnectedAcountId
            || ! $this->accountAcceptedForPayment($teacherConnectedAcountId)
        ):
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => "This teacher does not Stripe account or Stripe account not accept to payment",
            ]);
        endif;

        $paymentIntentConfig = [
            'amount' => $totalPrice * StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['multiplier'], // Multiply as & when required
            'currency' => StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['currency'],
            'metadata' => [
                'applyKids' => implode(',', $kidIds), //store list of kid apply
            ],
            'description' => 'Parent: ' . auth()->user()->id . '. Course: ' . $course->id,
        ];

        try {
            // Check table course_applications, find all uncomplete application of this user (user_id) to course_id
            $uncompleteApplications = $this->courseApplicationRepository->findBy([
                CourseApplicationConstants::COL_STATUS => CourseApplicationConstants::STATUS_UNCOMPLETE,
                CourseApplicationConstants::COL_COURSE_ID => $course->id,
                CourseApplicationConstants::COL_USER_ID => auth()->user()->id,
            ]);

            // Find uncomplete Stripe payment intent
            $paymentIntentReuse = null;
            $courseApplicationReuse = null;
            foreach ($uncompleteApplications as $uncompleteApplication):
                $paymentIntent = $this->stripe->paymentIntents->retrieve($uncompleteApplication->{CourseApplicationConstants::COL_PAYMENT_INTENT_ID});

                switch ($paymentIntent->status):
                    case StripeConstants::PAYMENT_INTENT_SUCCEEDED:
                        //call function to update for complate payment, add kid list to table application_details
                        $this->updateForCompletePayment($uncompleteApplication->id, explode(',', $paymentIntent->metadata->applyKids));
                        break;

                    case StripeConstants::PAYMENT_INTENT_PROCESSING:
                        break;

                    default:
                        $paymentIntentReuse = $paymentIntent;
                        $courseApplicationReuse = $uncompleteApplication;
                endswitch;
            endforeach;

            // Check if after update status for success payment, course is full
            if (! $this->courseIsEnoughSeat($course->id, count($request->applyKids))):
                return redirect()
                    ->route('lesson.detail', ['id' => $course->lesson_id])
                    ->with([
                        CommonConstants::MSG    => "Course is full",
                    ]);
            endif;


            $finalPaymentIntent = null;
            $finalApplication = null;
            // Reuse Stripe payment intent if exist
            if ($paymentIntentReuse) {
                $finalPaymentIntent = $this->stripe->paymentIntents->update($paymentIntentReuse->id, array_merge($paymentIntentConfig, [
                    'transfer_data' => [
                        'amount' => $teacherAmount * StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['multiplier'],
                    ],
                ]));
                $finalApplication = $courseApplicationReuse;
            }
            // In case all payment completed, create new payment intent, add new record to schedule_application table
            else {
                $paymentIntent = $this->stripe->paymentIntents->create(array_merge($paymentIntentConfig, [
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                    'transfer_data' => [
                        'amount' => $teacherAmount * StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['multiplier'],
                        'destination' => $teacherConnectedAcountId,
                    ],
                ]));

                $courseApplication = $this->courseApplicationRepository->create([
                    CourseApplicationConstants::COL_COURSE_ID => $course->id, // $request->schedule_id
                    CourseApplicationConstants::COL_USER_ID => auth()->user()->id,
                    CourseApplicationConstants::COL_LEARNER_QUESTION => json_encode($learnerQuestions), // $request->learner_question
                    CourseApplicationConstants::COL_PAYMENT_INTENT_ID => $paymentIntent->id,
                    CourseApplicationConstants::COL_STATUS => CourseApplicationConstants::STATUS_UNCOMPLETE,
                ]);
                if (! $courseApplication) {
                    return redirect()
                        ->route('top')
                        ->with([
                            CommonConstants::MSG    => __('messages.stripe.EM-001'),
                        ]);
                }

                $finalPaymentIntent = $paymentIntent;
                $finalApplication = $courseApplication;
            }

            return Inertia::render('Payment/Payment', [
                'lessonId' => $lesson->id,
                'clientSecret' => $finalPaymentIntent->client_secret,
                'applicationId' => $finalApplication->id,
                'courseId' => $course->id,
                // 'oldApplyForm' => $request->input('oldApplyForm'),
                'publicKey' => config('stripe.public_key'),
                'totalPrice' => round($totalPrice, 2),
                'symbol' => StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['symbol'],
            ]);

        } catch (\Throwable $th) {
            // throw error
            dd($th);
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        }
    }

    /**
     * Update status of course_application from uncomplete to complete
     * Add new application_detail for each kid in array applyKids
     *
     * @param String $courseApplicationId
     * @param Array $applyKids
     * @return boolean
     */
    public function updateForCompletePayment($courseApplicationId, $applyKids)
    {
        $courseApplication = $this->courseApplicationRepository->find($courseApplicationId);
        if ( (! $courseApplication) || 
            ($courseApplication->{CourseApplicationConstants::COL_STATUS} == CourseApplicationConstants::STATUS_COMPLETE)
        ) {
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => "Course not exit or completed",
            ]);
        }
        $course = $courseApplication->lessonCourse;

        try {
            $this->insertKidsToApplicationDetail($courseApplicationId, $applyKids);
            $this->insertUserSchedule($course);
            
            return true;
        } catch (\Throwable $th) {
            dd($th);

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.lesson_detail.EM-001'));
        }
    }

    /**
     * Get list kids from metadata of payment intent, add record to table application_detail for each kid
     *
     * @Route post("payment/complete")
     * @param Request $request
     * @return Response
     */
    public function completePayment(Request $request)
    {
        $courseApplication = $this->courseApplicationRepository->find($request->application_id);
        if ( (! $courseApplication) || 
            ($courseApplication->{CourseApplicationConstants::COL_STATUS} == CourseApplicationConstants::STATUS_COMPLETE)
        ) {
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        }

        // Use the payment intent ID stored when initiating payment to check status of payment
        $paymentIntent = $this->stripe->paymentIntents->retrieve($courseApplication->{CourseApplicationConstants::COL_PAYMENT_INTENT_ID});
        if ($paymentIntent->status != StripeConstants::PAYMENT_INTENT_SUCCEEDED) {
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        }

        if (! $this->updateForCompletePayment($courseApplication->id, explode(',', $paymentIntent->metadata->applyKids))) {
            return redirect()
                ->route('top')
                ->with([
                    CommonConstants::MSG    => __('messages.stripe.EM-001'),
                ]);
        }

        // Send mail
        $lesson = $courseApplication->lessonCourse->lesson;
        $course = $courseApplication->lessonCourse;
        $this->mailService->sendMailPaymentApplyComplete(Auth()->user(), [
            'application' => $courseApplication,
            'course' => [
                'start_time' => $course->start_time->format('H:i'),
                'end_time'  => $course->end_time->format('H:i')
            ],
            'lesson' => [
                'start_date' => $lesson->start_date->toDateString(),
                'lesson_time_in_minute' => $lesson->lesson_hour * 60 + $lesson->lesson_minute,
                'title' => $lesson->title,
            ],
            'teacher' => $courseApplication->lessonCourse->lesson->teacher,
        ]);
        
        //Send notification
        $this->notificationService->sendNotification(
            $courseApplication->lessonCourse->lesson->teacher,
            [
                'title'     => 'レッスン ' . $lesson->title .'に新しい申し込みがありました。',
                'target'    => route('schedule.list'),
            ],
            NotificationConstants::BROADCAST_TEACHER,
        );
        $this->notificationService->sendNotification(
            auth()->user(),
            [
                'title'     => $lesson->title . 'に申込みました。',
                'target'    => route('lesson.detail', ['id' => $lesson->id]),
            ],
            NotificationConstants::BROADCAST_USER,
        );

        return Inertia::render('Payment/PaymentComplete', []);
    }

    /**
     * Insert list kids to table application_detail 
     * Update status of application on table course_application to 1
     * 
     */
    public function insertKidsToApplicationDetail($courseApplicationId, $applyKids)
    {
        try {
            DB::transaction(function () use ($courseApplicationId, $applyKids) {
                //add to application detail
                foreach ($applyKids as $kidId) {
                    if (! $this->applicationDetailRepository->create([
                        ApplicationDetailConstants::COL_APPLICATION_ID => $courseApplicationId,
                        ApplicationDetailConstants::COL_KID_ID => $kidId,
                        ApplicationDetailConstants::COL_STATUS => ApplicationDetailConstants::STATUS_COMPLETE,
                    ])) {
                        throw ValidationException::withMessages([
                            CommonConstants::ERR_MSG => "Error when add kid to application_detail",
                        ]);
                    }
                }

                if (! $this->courseApplicationRepository->update($courseApplicationId, [
                    CourseApplicationConstants::COL_STATUS => CourseApplicationConstants::STATUS_COMPLETE,
                ])) {
                    throw ValidationException::withMessages([
                        CommonConstants::ERR_MSG => "Error when update status of application",
                    ]);
                }

            });
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollback();

            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => "Error when add kid to application_detail",
            ]);
        }
    }

    /**
     * Save list schedule from course to parent (kid), by insert into table user_schedule
     */
    public function insertUserSchedule($course)
    {

        try {
            DB::transaction(function () use ($course) {
                foreach ($course->course_schedules as $schedule):
                    $userSchedule = $this->userScheduleRepository->create([
                        'user_id' => auth()->user()->id,
                        'schedule_id' => $schedule->id,
                    ]);
                endforeach;
            });
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => "Error when insert user schedule",
            ]);
        }

    }
}
