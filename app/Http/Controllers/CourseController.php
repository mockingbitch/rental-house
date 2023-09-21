<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Constants\CommonConstants;
use App\Constants\LessonCourseConstants;
use App\Constants\UserScheduleConstants;
use App\Constants\CourseApplicationConstants;
use App\Constants\ApplicationDetailConstants;
use App\Constants\CourseScheduleConstants;
use App\Constants\UserConstants;
use App\Constants\NotificationConstants;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\CourseSchedule\CourseScheduleRepositoryInterface;
use App\Repositories\CourseApplication\CourseApplicationRepositoryInterface;
use App\Repositories\ApplicationDetail\ApplicationDetailRepositoryInterface;
use App\Repositories\UserSchedule\UserScheduleRepositoryInterface;
use App\Services\NotificationService;
use Inertia\Response;
use DB;
use Carbon\Carbon;
use App\Models\CourseSchedule;

class CourseController extends Controller
{
    /**
    * @var lessonRepository
    */
    protected $lessonRepository;

    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var lessonCourseRepository
     */
    protected $lessonCourseRepository;

    /**
     * @var courseScheduleRepository
     */
    protected $courseScheduleRepository;

    /**
     * @var userScheduleRepository
     */
    protected $userScheduleRepository;

    /**
     * @var courseApplicationRepository
     */
    protected $courseApplicationRepository;

    /**
     * @var applicationDetailRepository
     */
    protected $applicationDetailRepository;

    /**
     * @param LessonRepositoryInterface $lessonRepository
     * @param UserRepositoryInterface $userRepository
     * @param LessonCourseRepositoryInterface $lessonCourseRepository
     * @param CourseScheduleRepositoryInterface $courseScheduleRepository
     * @param UserScheduleRepositoryInterface $userScheduleRepository
     * @param CourseApplicationRepositoryInterface $courseApplicationRepository
     * @param ApplicationDetailRepositoryInterface $applicationDetailRepository
     */
    public function __construct(
        LessonRepositoryInterface $lessonRepository,
        UserRepositoryInterface $userRepository,
        LessonCourseRepositoryInterface $lessonCourseRepository,
        CourseScheduleRepositoryInterface $courseScheduleRepository,
        UserScheduleRepositoryInterface $userScheduleRepository,
        CourseApplicationRepositoryInterface $courseApplicationRepository,
        ApplicationDetailRepositoryInterface $applicationDetailRepository,
        public NotificationService $notificationService,
    ) {
        $this->lessonRepository         = $lessonRepository;
        $this->userRepository           = $userRepository;
        $this->lessonCourseRepository   = $lessonCourseRepository;
        $this->courseScheduleRepository = $courseScheduleRepository;
        $this->userScheduleRepository   = $userScheduleRepository;
        $this->courseApplicationRepository   = $courseApplicationRepository;
        $this->applicationDetailRepository   = $applicationDetailRepository;
    }

    /**
     * @Route get("/reserved")
     * @return Response
     */
    public function getListReserved(): Response
    {
        $courseApplied = [];
        $courses = $this->lessonCourseRepository->all();
        foreach ($courses as $course):
            $lesson = $this->lessonRepository->find($course->lesson_id);
            foreach ($course->course_applications as $courseApplication):
                if ($courseApplication->user_id === auth()->user()->id && $courseApplication->status === '1'):
                    $course['group_date'] = Carbon::parse($courseApplication->created_at)->format('Y/m/d');
                    $course['lesson'] = $lesson;
                    $scheduleEnd = CourseSchedule::query()->where(['course_id' => $course->id])->orderBy('date', 'desc')->orderBy('end_time', 'desc')->first();
                    if ($scheduleEnd) {
                        $scheduleEnd['compare'] =  Carbon::parse($scheduleEnd['date']." ".Carbon::parse($scheduleEnd['end_time'])->format('H:i:s'));
                        if ($scheduleEnd->compare > Carbon::now()) {
                            $courseApplied[] = $course;
                        }
                    }
                endif;
            endforeach;
        endforeach;
        $sortDate = collect($courseApplied)->sortBy('group_date')->all();
        $listScheduleSorted = array_values($sortDate);
        $courseAppliedGroupBy = collect(array_unique($listScheduleSorted))->groupBy('group_date')->toArray();

        return Inertia::render('User/Reserved', [
            'course_applied' => $courseAppliedGroupBy
        ]);
    }

    /**
     * @Route get("/reserved/skip")
     * @return RedirectResponse
     */
    public function skipSchedule(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->list_schedule as $scheduleId):
                    $userSchedules = $this->userScheduleRepository->findBy([
                        UserScheduleConstants::COL_USER_ID => auth()->user()->id,
                        UserScheduleConstants::COL_SCHEDULE_ID => $scheduleId,
                    ]);
                    if ($userSchedules) :
                        foreach ($userSchedules as $userSchedule):
                            $skipSchedule = $this->userScheduleRepository->update($userSchedule->id, [UserScheduleConstants::COL_STATUS => UserScheduleConstants::STATUS_ACTIVE]);
                        endforeach;
                    endif;
                endforeach;

                foreach ($request->list_id as $scheduleId):
                    $userSchedules = $this->userScheduleRepository->findBy([
                        UserScheduleConstants::COL_USER_ID => auth()->user()->id,
                        UserScheduleConstants::COL_SCHEDULE_ID => $scheduleId,
                        UserScheduleConstants::COL_STATUS => UserScheduleConstants::STATUS_ACTIVE,
                    ]);
                    if ($userSchedules) :
                        foreach ($userSchedules as $userSchedule):
                            $skipSchedule = $this->userScheduleRepository->update($userSchedule->id, [UserScheduleConstants::COL_STATUS => UserScheduleConstants::STATUS_SKIP]);
                        endforeach;
                    endif;
                endforeach;
            });

            DB::commit();

            return redirect()
                ->route('user.reserved')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    /**
     * @Route get("/reserved/cancel")
     * @return RedirectResponse
     */
    public function cancelCourse(Request $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $courseApplieds = $this->courseApplicationRepository->findBy([
                    CourseApplicationConstants::COL_COURSE_ID => $request->course_id,
                    CourseApplicationConstants::COL_USER_ID => auth()->user()->id,
                ]);
                if ($courseApplieds) :
                    foreach ($courseApplieds as $courseApplied) :
                        $courseCancel = $this->courseApplicationRepository->update($courseApplied->id, [
                            CourseApplicationConstants::COL_STATUS => CourseApplicationConstants::STATUS_CANCEL,
                            CourseApplicationConstants::COL_CANCEL_REASON => $request->reason_other ? $request->reason_other : $request->reason
                        ]);

                        $applyDetails = $this->applicationDetailRepository->findBy([
                            ApplicationDetailConstants::COL_APPLICATION_ID => $courseApplied->id
                        ]);
                        if ($applyDetails) :
                            foreach ($applyDetails as $applyDetail) :
                                $applyDetailCancel = $this->applicationDetailRepository->update($applyDetail->id, [
                                    ApplicationDetailConstants::COL_STATUS => ApplicationDetailConstants::STATUS_UNCOMPLETE,
                                ]);
                            endforeach;
                        endif;

                        $courseSchedules = $this->courseScheduleRepository->findBy([
                            CourseScheduleConstants::COL_COURSE_ID => $courseApplied->course_id,
                        ]);
                        foreach ($courseSchedules as $courseSchedule) :
                            $userSchedules = $this->userScheduleRepository->findBy([
                                UserScheduleConstants::COL_SCHEDULE_ID => $courseSchedule->id,
                                UserScheduleConstants::COL_USER_ID => auth()->user()->id,
                            ]);
                            if ($userSchedules) :
                                foreach ($userSchedules as $userSchedule):
                                    $userScheduleDelete = $this->userScheduleRepository->delete($userSchedule->id);
                                endforeach;
                            endif;
                        endforeach;
                    endforeach;
                endif;
            });
            DB::commit();
            $course = $this->lessonCourseRepository
                ->findOneBy([
                    LessonCourseConstants::COL_ID => $request->course_id
                ]);
            $this->notificationService->sendNotification(
                auth()->user(),
                [
                    'title'     => 'レッスン ' . $course->lesson->title . ' がキャンセルされました。
                    キャンセル理由 : ' . ($request->reason_other ? $request->reason_other : $request->reason),
                    'target'    => route('user.reserved'),
                ],
                NotificationConstants::BROADCAST_USER,
            );
            $teacher = $this->userRepository
                ->findOneBy([
                    UserConstants::COL_ID => $course->lesson->teacher_id
                ]);

            $this->notificationService->sendNotification(
                $teacher,
                [
                    'title'     => 'レッスン  ' . $course->lesson->title . ' ' . $course->title . ' が解約されました。
                    解約理由 : ' . ($request->reason_other ? $request->reason_other : $request->reason),
                    'target'    => route('schedule.list'),
                ],
                NotificationConstants::BROADCAST_TEACHER,
            );

            return redirect()
                ->route('user.reserved')
                ->with(CommonConstants::MSG, __('messages.create_course.SM-001'));
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(CommonConstants::MSG, __('messages.create_course.EM-001'));
        }
    }

    public function getCourseReview()
    {
        return Inertia::render('User/Review');
    }
}
