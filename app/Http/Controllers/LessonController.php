<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\LessonCreateRequest;
use App\Http\Requests\LessonStep1Request;
use App\Http\Requests\LessonStep2Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ScheduleApplyRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Constants\LessonConstants;
use App\Constants\UserConstants;
use App\Constants\CommonConstants;
use App\Constants\MaterialConstants;
use App\Constants\CategoryConstants;
use App\Constants\LessonCourseConstants;
use App\Constants\RequestApplicationConstants;
use App\Constants\ViewConstants;
use App\Constants\CourseScheduleConstants;
use App\Constants\StripeConstants;
use App\Constants\NotificationConstants;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\Material\MaterialRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\Kid\KidRepositoryInterface;
use App\Repositories\RequestApplication\RequestApplicationRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\LessonView\ViewRepositoryInterface;
use App\Repositories\CourseSchedule\CourseScheduleRepositoryInterface;
use App\Repositories\UserSchedule\UserScheduleRepositoryInterface;
use App\Services\NotificationService;
use Inertia\Response;
use DB;
use Carbon\Carbon;

class LessonController extends Controller
{
    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @var materailRepository
     */
    protected $materialRepository;

    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var reviewRepository
     */
    protected $reviewRepository;

    /**
     * @var lessonCourseRepository
     */
    protected $lessonCourseRepository;

    /**
     * @var kidRepository
     */
    protected $kidRepository;

    /**
     * @var requestApplicationRepository
     */
    protected $requestApplicationRepository;

    /**
     * @var viewRepository
     */
    protected $viewRepository;

    /**
     * @var courseScheduleRepository
     */
    protected $courseScheduleRepository;

    /**
     * @var userScheduleRepository
     */
    protected $userScheduleRepository;

    /**
     * @param LessonRepositoryInterface $lessonRepository
     * @param MaterialRepositoryInterface $materialRepository
     * @param UserRepositoryInterface $userRepository
     * @param ReviewRepositoryInterface $reviewRepository
     * @param LessonCourseRepositoryInterface $lessonCourseRepository
     * @param KidRepositoryInterface $kidRepository
     * @param RequestApplicationRepositoryInterface $requestApplicationRepository
     * @param ViewRepositoryInterface $requestApplicationRepository
     * @param CourseScheduleRepositoryInterface $courseScheduleRepository
     * @param UserScheduleRepositoryInterface $userScheduleRepository
     */
    public function __construct(
        LessonRepositoryInterface $lessonRepository,
        MaterialRepositoryInterface $materialRepository,
        UserRepositoryInterface $userRepository,
        ReviewRepositoryInterface $reviewRepository,
        LessonCourseRepositoryInterface $lessonCourseRepository,
        KidRepositoryInterface $kidRepository,
        RequestApplicationRepositoryInterface $requestApplicationRepository,
        ViewRepositoryInterface $viewRepository,
        CourseScheduleRepositoryInterface $courseScheduleRepository,
        UserScheduleRepositoryInterface $userScheduleRepository,
        public RequestRepositoryInterface $requestRepository,
        public NotificationService $notificationService,
    ) {
        $this->lessonRepository   = $lessonRepository;
        $this->materialRepository   = $materialRepository;
        $this->userRepository   = $userRepository;
        $this->reviewRepository   = $reviewRepository;
        $this->lessonCourseRepository   = $lessonCourseRepository;
        $this->kidRepository   = $kidRepository;
        $this->requestApplicationRepository   = $requestApplicationRepository;
        $this->viewRepository   = $viewRepository;
        $this->courseScheduleRepository   = $courseScheduleRepository;
        $this->userScheduleRepository   = $userScheduleRepository;
    }

    /**
     * @Route get("/create-lesson")
     * @return Response
     */
    public function viewCreateLesson(Request $request) : Response
    {
        return Inertia::render('Lesson/CreateLessonForm', [
            'request_id'  => $request->request_id,
        ]);
    }

    /**
     * @Route post("/create-lesson/step1")
     * @param LessonStep1Request $request
     */
    public function createLessonStep1(LessonStep1Request $request)
    {
    }

    /**
     * @Route post("/create-lesson/step2")
     * @param LessonStep2Request $request
     */
    public function createLessonStep2(LessonStep2Request $request)
    {
    }

    /**
     * @Route post("/create-lesson/step3")
     * @param LessonCreateRequest $request
     */
    public function createLessonStep3(LessonCreateRequest $request)
    {
        try {
            $lesson_create = DB::transaction(function () use ($request) {
                $domain = request()->getSchemeAndHttpHost();
                $data = $request->toArray();
                $data[LessonConstants::COL_TEACHER_ID] = auth()->user()->id;

                if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]) :
                    $short_video_for_learner = $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]->store(LessonConstants::STORAGE_FOR_LEARNER);
                    $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER] = $domain.'/'.str_replace('public/','storage/',$short_video_for_learner);
                endif;

                $cover_image = $data[LessonConstants::COL_COVER_IMAGE]->store(LessonConstants::STORAGE_COVER_IMAGE);
                $short_video_for_parent = $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]->store(LessonConstants::STORAGE_FOR_PARENT);
                $data[LessonConstants::COL_COVER_IMAGE] = $domain.'/'.str_replace('public/','storage/',$cover_image);
                $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT] = $domain.'/'.str_replace('public/','storage/',$short_video_for_parent);;

                $lesson_create = $this->lessonRepository->create($data);

                foreach ($request->file_upload as $key => $value) :
                    if ($value) :
                        $file = $value->store(MaterialConstants::STORAGE_FILE_UPLOAD);
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                            MaterialConstants::COL_FILE => $file,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                    if (!$value) :
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;
                endforeach;

                if ($request->request_id) :
                    if ($requestUser = $this->requestRepository->find($request->request_id)) :
                        $request_applied = $this->requestApplicationRepository->create([
                            RequestApplicationConstants::COL_REQUEST_ID => $request->request_id,
                            RequestApplicationConstants::COL_LESSON_ID => $lesson_create->id
                        ]);
                        $user = $this->userRepository->find($requestUser->user_id);
                        if ($user) :
                            $this->notificationService->sendNotification(
                                $user,
                                [
                                    'title'     => 'リクエスト ' . $lesson_create->title . ' に提案がありました。',
                                    'target'    => route('request.index'),
                                ],
                                NotificationConstants::BROADCAST_USER,
                            );
                        endif;
                    endif;
                endif;

                return $lesson_create;
            });
            DB::commit();

            return redirect()
                ->route('create.lesson.success', [
                    'lesson_id' => $lesson_create->id
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $data = $request->toArray();
            $domain = request()->getSchemeAndHttpHost();
            if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]) :
                $short_video_for_learner = $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]->store(LessonConstants::STORAGE_FOR_LEARNER);
                $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_learner);
            endif;

            $cover_image = $data[LessonConstants::COL_COVER_IMAGE]->store(LessonConstants::STORAGE_COVER_IMAGE);
            $short_video_for_parent = $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]->store(LessonConstants::STORAGE_FOR_PARENT);
            $data[LessonConstants::COL_COVER_IMAGE] = $domain.'/'.str_replace('public/', 'storage/', $cover_image);
            $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_parent);

            return Inertia::render('Lesson/CreateLessonFailed', [
                'data' => $data
            ]);
        }
    }

    /**
     * @Route post("/save-draft")
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveDraft(Request $request) : RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $domain = request()->getSchemeAndHttpHost();
                $data = $request->toArray();
                $data[LessonConstants::COL_TEACHER_ID] = auth()->user()->id;
                $data[LessonConstants::COL_STATUS] = LessonConstants::STATUS_DRAFT;

                if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]) :
                    $short_video_for_learner = $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]->store(LessonConstants::STORAGE_FOR_LEARNER);
                    $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_learner);
                endif;

                if ($data[LessonConstants::COL_COVER_IMAGE]) :
                    $cover_image = $data[LessonConstants::COL_COVER_IMAGE]->store(LessonConstants::STORAGE_COVER_IMAGE);
                    $data[LessonConstants::COL_COVER_IMAGE] = $domain.'/'.str_replace('public/', 'storage/', $cover_image);
                endif;

                if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]) :
                    $short_video_for_parent = $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]->store(LessonConstants::STORAGE_FOR_PARENT);
                    $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_parent);
                endif;

                if ($request->lesson_id) :
                    $lesson_create = $this->lessonRepository->update($request->lesson_id, $data);
                else :
                    $lesson_create = $this->lessonRepository->create($data);
                endif;

                foreach ($request->file_upload as $key => $value) :
                    if ($value) :
                        $file = $value->store(MaterialConstants::STORAGE_FILE_UPLOAD);
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                            MaterialConstants::COL_FILE => $file,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                    if (!$value) :
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                endforeach;
            });
            DB::commit();
            if ($request->previous_page == 'listLesson') :
                return redirect()
                    ->route('lesson.list')
                    ->with(CommonConstants::MSG, __('messages.save_draft.SM-001'));
            else:
                return redirect()
                    ->route('teacher.dashboard')
                    ->with(CommonConstants::MSG, __('messages.save_draft.SM-001'));
            endif;
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
               ->back()
               ->with(CommonConstants::MSG, __('messages.save_draft.EM-001'));
        }
    }

    /**
     * @Route post("/save-draft-error")
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveDraftError(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->toArray();
                $data[LessonConstants::COL_TEACHER_ID] = auth()->user()->id;
                $data[LessonConstants::COL_STATUS] = LessonConstants::STATUS_DRAFT;

                $lesson_create = $this->lessonRepository->create($data);

                foreach ($request->file_upload as $key => $value) :
                    if ($value) :
                        $file = $value->store(MaterialConstants::STORAGE_FILE_UPLOAD);
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                            MaterialConstants::COL_FILE => $file,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                    if (!$value) :
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                endforeach;
            });
            DB::commit();

            return redirect()
                ->route('teacher.dashboard')
                ->with(CommonConstants::MSG, __('messages.save_draft.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
               ->route('teacher.dashboard')
               ->with(CommonConstants::MSG, __('messages.save_draft.EM-001'));
        }
    }

    /**
     * @Route post("/save-draft-error")
     * @return Response
     */
    public function lessonCreateSuccess(Request $request) : Response
    {
        return Inertia::render('Lesson/CreateLessonSuccess', [
            'lesson_id' => $request->lesson_id
        ]);
    }

    /**
     * @Route get("lesson.detail")
     * @param id $request
     */
    public function lessonDetail($id)
    {
        try {
            $lesson = $this->lessonRepository->find($id);
            $teacher = $this->userRepository->find($lesson->teacher_id);
            $reviews = $this->reviewRepository->getUserReviews($id);
            $lesson_courses = $this->lessonCourseRepository->getScheduleApplications([LessonCourseConstants::COL_LESSON_ID => $id]);

            if (auth()->user()) :
                $user_agent = $this->viewRepository->checkUserAgent(auth()->user()->id, $id);
            else :
                $user_agent = $this->viewRepository->checkUserAgent(\Request::ip(), $id);
            endif;

            if (!$user_agent):
                $user_agent_create = $this->viewRepository->create([
                    ViewConstants::COL_USER_AGENT => auth()->user() ? auth()->user()->id : \Request::ip(),
                    ViewConstants::COL_LESSON_ID  => $lesson->id
                ]);
                $lesson->view = $lesson->view + 1;
                $lesson->save();
            endif;

            return Inertia::render('Lesson/LessonDetail', [
                'lessons' => $lesson,
                'teacher' => $teacher,
                'reviews' => $reviews,
                'lesson_courses' => $lesson_courses,
            ]);
        } catch (\Throwable $th) {
            return redirect()
               ->back()
               ->with(CommonConstants::MSG, __('messages.lesson_detail.EM-001'));
        }
    }

    /**
     * When the user clicks the "Apply" button corresponding to a course in the Lesson detail screen, this function will be called.
     *
     * @Route get('/course/{id}', name = 'course.apply');
     * @return Response
     */
    public function courseApply($id)
    {
        $lessonCourse = $this->lessonCourseRepository->find($id);
        $lesson = $this->lessonRepository->find($lessonCourse->lesson_id);
        $kids = $this->kidRepository->findBy(['parent_id' => auth()->user()->id]);

        return Inertia::render('Lesson/ScheduleApply', [
            'lesson' => $lesson,
            'lessonCourse' => $lessonCourse,
            'kids' => $kids,
            'oldApplyForm' => 
                (session()->has('oldApplyForm') && strtok(url()->previous(), '?') === route('payment.initiate')) 
                ? session()->pull('oldApplyForm') 
                : null,   //check if request from payment page to confirm payment page
            'symbol' => StripeConstants::PAYMENT_CURRENCY[$lesson->currency]['symbol'],
        ]);
    }

    /**
     * When the user selecs kid and clicks the "Apply" button, this function will be called.
     *
     * @Route get('/course/payment/{id}', name = 'course.apply.payment');
     * @return Response
     */
    public function registerNewKid($id, ScheduleApplyRequest $request)
    {
        try {
            $applyKids = [];
            DB::transaction(function () use ($request, &$applyKids) {
                foreach ($request->applyKids as $kid) :
                    $applyKids[] = $this->kidRepository->createKidIfNotExist(auth()->user()->id, $kid);
                endforeach;
            });
            DB::commit();

            return Inertia::render('Lesson/ScheduleApply', [
                // 'newKids' => $new_kids,
                'lesson' => $request->lesson,
                'lessonCourse' => $request->lessonCourse,
                'kids' => $this->kidRepository->findBy(['parent_id' => auth()->user()->id]),
                'applyKids' => $applyKids,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.lesson_detail.EM-001'));
        }
    }

    /**
     * @Route get("lesson.list'")
     * @return Response
     */
    public function lessonList(Request $request): Response
    {
        $lessons = $this->lessonRepository->findBy([LessonConstants::COL_TEACHER_ID => auth()->user()->id]);

        return Inertia::render('Teacher/LessonList', [
            'lessons' => $lessons,
            'selected' => $request->selected,
        ]);
    }

    /**
     * Route get("lesson.list'")
     * @param [type] $id
     * @return Response
     */
    public function createCourseView($id) : Response
    {
        $lesson = $this->lessonRepository->find($id);

        return Inertia::render('Teacher/CourseCreate', [
            'lesson' => $lesson,
            'create' => true,
            'update' => false,
        ]);
    }

    /**
     * Route get("lesson.list'")
     * @param Request $request, $id
     * @return RedirectResponse
     */
    public function createCourse(Request $request, $id): RedirectResponse
    {
        $teacher_schedules = $this->lessonRepository->getListSchedule(auth()->user()->id, 'array');
        $schedule_duplicate = $this->courseScheduleRepository->checkDuplicate($teacher_schedules, $request->course_schedules);
        $lesson_schedules = $this->lessonRepository->getLessontSchedule($id);
        $furthestSchedule = $this->courseScheduleRepository->getLessonStartTime($lesson_schedules, $request->course_schedules);
        $latedSchedule = $this->courseScheduleRepository->getLessonEndTime($lesson_schedules, $request->course_schedules);

        if ($schedule_duplicate) :

            throw ValidationException::withMessages([
                'message' => 'Schedule duplicates are not allowed',
            ]);
        endif;
        try {
            $lesson = $this->lessonRepository->find($id);
            $course_data = [
                LessonCourseConstants::COL_LESSON_ID    => $lesson->id,
                LessonCourseConstants::COL_TITLE        => $request->course_title,
                LessonCourseConstants::COL_DEADLINE     => $request->course_deadline,
                LessonCourseConstants::COL_DATE         => $request->course_schedules[0]['date'],
                LessonCourseConstants::COL_START_TIME   => $request->course_schedules[0]['start_time'],
                LessonCourseConstants::COL_END_TIME     => $request->course_schedules[0]['end_time'],
                LessonCourseConstants::COL_MAX_SEAT     => $lesson->max_learner,
                LessonCourseConstants::COL_WEEKDAY      => json_encode($request->weekday),
            ];

            DB::transaction(function () use ($request, &$new_kids, $course_data, $furthestSchedule, $latedSchedule, $id) {
                $lesson = $this->lessonRepository->update($id, [
                    LessonConstants::COL_START_DATE => $furthestSchedule,
                    LessonConstants::COL_END_DATE => $latedSchedule,
                ]);
                $new_schedules = [];
                foreach ($request->course_schedules as $schedule) :
                    $schedule['compare'] =  Carbon::parse($schedule['date']." ".Carbon::parse($schedule['start_time'])->format('H:i:s'));
                    $new_schedules[] = $schedule;
                endforeach;
                $sortDate = collect($new_schedules)->sortBy('compare')->all();
                $listScheduleSorted = array_values($sortDate);

                $lesson_course = $this->lessonCourseRepository->create($course_data);

                foreach ($listScheduleSorted as $course_schedule) :
                    $schedule = $this->courseScheduleRepository->create([
                        CourseScheduleConstants::COL_COURSE_ID  =>  $lesson_course->id,
                        CourseScheduleConstants::COL_DATE       =>  $course_schedule[CourseScheduleConstants::COL_DATE],
                        CourseScheduleConstants::COL_START_TIME =>  $course_schedule[CourseScheduleConstants::COL_START_TIME],
                        CourseScheduleConstants::COL_END_TIME   =>  $course_schedule[CourseScheduleConstants::COL_END_TIME],
                    ]);
                endforeach;
            });
            DB::commit();

            return redirect()
                ->route('lesson.list')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->route('course.create', ['id' => $id])
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    public function editCourseView($id): Response
    {
        $course = $this->lessonCourseRepository->find($id);
        $lesson = $this->lessonRepository->find($course->lesson_id);

        return Inertia::render('Teacher/CourseCreate', [
            'lesson' => $lesson,
            'course' => $course,
            'create' => false,
            'update' => true,
        ]);
    }

    public function editCourse(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $courseUpdate = $this->lessonCourseRepository->update($id, [
                    LessonCourseConstants::COL_DEADLINE => $request->course_deadline,
                ]);

                $schedules_delete = $this->courseScheduleRepository->deleteByCourseId($id);
                $teacher_schedules = $this->lessonRepository->getListSchedule(auth()->user()->id, 'array');
                $schedule_duplicate = $this->courseScheduleRepository->checkDuplicate($teacher_schedules, $request->course_schedules);
                $course = $this->lessonCourseRepository->update($id, [
                    LessonCourseConstants::COL_DATE  => $request->course_schedules[0]['date'],
                ]);

                if ($schedule_duplicate) :
                    throw ValidationException::withMessages([
                        'message' => 'Schedule duplicates are not allowed',
                    ]);
                endif;
                $course = $this->lessonCourseRepository->find($id);
                $lesson_schedules = $this->lessonRepository->getLessontSchedule($course->lesson_id);
                $furthestSchedule = $this->courseScheduleRepository->getLessonStartTime($lesson_schedules, $request->course_schedules);
                $latedSchedule = $this->courseScheduleRepository->getLessonEndTime($lesson_schedules, $request->course_schedules);

                $lesson = $this->lessonRepository->update($course->lesson_id, [
                    LessonConstants::COL_START_DATE => $furthestSchedule,
                    LessonConstants::COL_END_DATE => $latedSchedule,
                ]);

                $new_schedules = [];
                foreach ($request->course_schedules as $schedule) :
                    $schedule['compare'] =  Carbon::parse($schedule['date']." ".Carbon::parse($schedule['start_time'])->format('H:i:s'));
                    $new_schedules[] = $schedule;
                endforeach;
                $sortDate = collect($new_schedules)->sortBy('compare')->all();
                $listScheduleSorted = array_values($sortDate);

                foreach ($listScheduleSorted as $course_schedule) :
                    $schedule = $this->courseScheduleRepository->create([
                        CourseScheduleConstants::COL_COURSE_ID  =>  $id,
                        CourseScheduleConstants::COL_DATE       =>  $course_schedule[CourseScheduleConstants::COL_DATE],
                        CourseScheduleConstants::COL_START_TIME =>  $course_schedule[CourseScheduleConstants::COL_START_TIME],
                        CourseScheduleConstants::COL_END_TIME   =>  $course_schedule[CourseScheduleConstants::COL_END_TIME],
                    ]);
                endforeach;
            });
            DB::commit();

            return redirect()
                ->route('lesson.list')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function deleteCourse($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $course_delete = $this->lessonCourseRepository->delete($id);
            });
            DB::commit();

            return redirect()
                ->route('lesson.list')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->route('course.create', ['id' => $id])
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    public function viewEditLesson(Request $request, $id)
    {
        $draft_lesson = $this->lessonRepository->find($id);
        if ($draft_lesson->teacher_id !== auth()->user()->id):
            return redirect()
                ->back();
        endif;
        return Inertia::render('Lesson/CreateLessonForm', [
            'draft_lesson'  => $draft_lesson,
            'previous_page'  => $request->draft,
        ]);
    }

    public function editLesson(Request $request, $id)
    {
        try {
            $lesson_create = DB::transaction(function () use ($request, $id) {
                $domain = request()->getSchemeAndHttpHost();
                $data = $request->toArray();
                $data[LessonConstants::COL_TEACHER_ID] = auth()->user()->id;

                if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]) :
                    $short_video_for_learner = $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]->store(LessonConstants::STORAGE_FOR_LEARNER);
                    $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_learner);
                endif;

                $cover_image = $data[LessonConstants::COL_COVER_IMAGE]->store(LessonConstants::STORAGE_COVER_IMAGE);
                $short_video_for_parent = $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]->store(LessonConstants::STORAGE_FOR_PARENT);
                $data[LessonConstants::COL_COVER_IMAGE] = $domain.'/'.str_replace('public/', 'storage/', $cover_image);
                $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_parent);
                $data[LessonConstants::COL_STATUS] = '1';

                $lesson_create = $this->lessonRepository->update($id, $data);

                foreach ($request->file_upload as $key => $value) :
                    if ($value) :
                        $file = $value->store(MaterialConstants::STORAGE_FILE_UPLOAD);
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                            MaterialConstants::COL_FILE => $file,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;

                    if (!$value) :
                        $material_data = [
                            MaterialConstants::COL_LESSON_NUMBER => $key + 1,
                            MaterialConstants::COL_LESSON_ID => $lesson_create->id,
                        ];
                        $material = $this->materialRepository->create($material_data);
                    endif;
                endforeach;

                if ($request->request_id) {
                    $request_applied = $this->requestApplicationRepository->create([
                        RequestApplicationConstants::COL_REQUEST_ID => $request->request_id,
                        RequestApplicationConstants::COL_LESSON_ID => $lesson_create->id
                    ]);
                }

                return $lesson_create;
            });
            DB::commit();

            return redirect()
                ->route('create.lesson.success', [
                    'lesson_id' => $lesson_create->id
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $data = $request->toArray();

            if ($data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]) :
                $short_video_for_learner = $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER]->store(LessonConstants::STORAGE_FOR_LEARNER);
                $data[LessonConstants::COL_SHORT_VIDEO_FOR_LEARNER] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_learner);
            endif;

            $cover_image = $data[LessonConstants::COL_COVER_IMAGE]->store(LessonConstants::STORAGE_COVER_IMAGE);
            $short_video_for_parent = $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT]->store(LessonConstants::STORAGE_FOR_PARENT);
            $data[LessonConstants::COL_COVER_IMAGE] = $domain.'/'.str_replace('public/', 'storage/', $cover_image);
            $data[LessonConstants::COL_SHORT_VIDEO_FOR_PARENT] = $domain.'/'.str_replace('public/', 'storage/', $short_video_for_parent);

            return Inertia::render('Lesson/CreateLessonFailed', [
                'data' => $data
            ]);
        }
    }

    public function deleteLesson($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $lessonDelete = $this->lessonRepository->delete($id);
            });
            DB::commit();

            return redirect()
                ->route('teacher.dashboard')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    public function suspendLesson($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $lessonDelete = $this->lessonRepository->update($id, [LessonConstants::COL_STATUS => LessonConstants::STATUS_SUSPEND]);
            });
            DB::commit();

            return redirect()
                ->route('teacher.dashboard')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    public function draftLesson(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $draftLesson = $this->lessonRepository->update($request->lesson_id, ['status' => '2']);
            });
            DB::commit();

            return redirect()
                ->route('lesson.list')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }
}
