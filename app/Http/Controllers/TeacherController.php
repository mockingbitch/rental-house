<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use App\Repositories\Lesson\LessonRepositoryInterface;
use App\Repositories\ApplicationDetail\ApplicationDetailRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Repositories\TeacherInformation\TeacherInformationRepositoryInterface;
use App\Repositories\CourseApplication\CourseApplicationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use App\Constants\UserConstants;
use App\Constants\ReviewConstants;
use App\Constants\LessonConstants;
use App\Constants\TeacherInformationConstants;
use App\Http\Requests\TeacherAccountRequest;
use Inertia\Response;

class TeacherController extends Controller
{
    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @var applicationDetailRepository
     */
    protected $applicationDetailRepository;

    /**
     * @var reviewRepository
     */
    protected $reviewRepository;

    /**
     * @var teacherRepository
     */
    protected $teacherRepository;

    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var fileService
     */
    protected $fileService;

    /**
     * @var courseApplicationRepository
     */
    protected $courseApplicationRepository;

    /**
     * @param LessonRepositoryInterface $lessonRepository
     * @param ApplicationDetailRepositoryInterface $applicationDetailRepository
     * @param ReviewRepositoryInterface $reviewRepository
     * @param TeacherInformationRepositoryInterface $teacherRepository
     * @param UserRepositoryInterface $userRepository
     * @param FileService $fileService
     * @param CourseApplicationRepositoryInterface $courseApplicationRepository
     */
    public function __construct(
        LessonRepositoryInterface $lessonRepository,
        ApplicationDetailRepositoryInterface $applicationDetailRepository,
        ReviewRepositoryInterface $reviewRepository,
        TeacherInformationRepositoryInterface $teacherRepository,
        UserRepositoryInterface $userRepository,
        FileService $fileService,
        CourseApplicationRepositoryInterface $courseApplicationRepository,
    ) {
        $this->lessonRepository = $lessonRepository;
        $this->applicationDetailRepository = $applicationDetailRepository;
        $this->reviewRepository = $reviewRepository;
        $this->teacherRepository = $teacherRepository;
        $this->userRepository   = $userRepository;
        $this->fileService = $fileService;
        $this->courseApplicationRepository = $courseApplicationRepository;
    }


    /**
     * @Route("/", name="teacher.dashboard")
     * @return Response
     */
    public function index(): Response
    {
        $lessons = $this->lessonRepository->getListLesson(auth()->user()->id);
        $totalLearnerApplied = $this->applicationDetailRepository->totalLearnerApplied(auth()->user()->id);
        $reviews = [];
        foreach ($lessons as $lesson) :
            foreach ($lesson->review as $review):
                $review->lesson_id = $lesson->id;
                $reviews[] = $review;
            endforeach;
        endforeach;

        if ($reviews) :
            $latestReview = collect($reviews)->sortBy('created_at')->all();

            return Inertia::render('Teacher/TeacherDashboard', [
                'lessons' => $lessons,
                'total_learner_applied' => $totalLearnerApplied,
                'latest_review' => $latestReview[count($latestReview) - 1],
            ]);
        endif;

        return Inertia::render('Teacher/TeacherDashboard', [
            'lessons' => $lessons,
            'total_learner_applied' => $totalLearnerApplied,
        ]);
    }

    /**
     * @Route("/teacher/record", name="record.list")
     * @return Response
     */
    public function getListRecord(): Response
    {
        $lessons = $this->lessonRepository->getListLesson(auth()->user()->id);
        $totalLearnerApplied = $this->applicationDetailRepository->totalLearnerApplied(auth()->user()->id);

        return Inertia::render('Teacher/Record', [
            'lessons' => $lessons,
            'total_learner_applied' => $totalLearnerApplied,
        ]);

    }

    /**
     * @Route("/teacher/schedule", name="schedule.list")
     * @return Response
     */
    public function getScheduleList(): Response
    {
        $schedules = $this->lessonRepository->getListSchedule(auth()->user()->id, 'object');
        $sortDate = collect($schedules)->sortBy('compare')->all();
        $listScheduleSorted = array_values($sortDate);

        foreach ($listScheduleSorted as $schedule) :
            $schedule->course = $schedule->lessonCourse;
        endforeach;

        return Inertia::render('Teacher/Schedule', [
            'schedules' => $listScheduleSorted,
        ]);
    }

    /**
     * @Route get("/teacher/review/{id}", name="schedule.review")
     * @param integer|null $id
     * @return Response
     */
    public function getScheduleReview(?int $id, Request $request): Response
    {
        try {
            if ($request->review_id) :
                $new_review = $this->reviewRepository->update($request->review_id, ['status' => '0']);
            else:
                $new_review = $this->reviewRepository->update($id, ['status' => 0]);
            endif;
            $lesson = $this->lessonRepository->findOneOrFail($id);
            $listReview = $this->reviewRepository->findBy([
                ReviewConstants::COL_LESSON_ID => $lesson->id,
            ]);
            return Inertia::render('Teacher/ScheduleReview', [
                'lesson'                => $lesson,
                'listReview'            => $listReview,
                'isAllReview'           => false,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @Route get("/teacher/review", name="total.review")
     * @return Response
     */
    public function getTotalReview(): Response
    {
        try {
            $listReviewOfTeacher = [];
            $listLessonOfTeacher = $this->lessonRepository->findBy([
                LessonConstants::COL_TEACHER_ID => auth()->user()->id,
            ]);
            $listReview = $this->reviewRepository
                ->getListReviewOfTeacher($listLessonOfTeacher);
            $collectionReview = collect($listReview);
            $collectionReview = $collectionReview->sortByDesc(function ($item, $key) {
                return $item->created_at;
            });

            foreach ($collectionReview as $item) :
                $listReviewOfTeacher[] = $item;
            endforeach;

            return Inertia::render('Teacher/ScheduleReview', [
                'isAllReview'           => true,
                'listReviewOfTeacher'   => $listReviewOfTeacher,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @Route get("/teacher/account", name="teacher.account")
     * @return Response
     */
    public function account(): Response
    {
        $teacher = auth()->user();
        if ($teacher) :
            $teacher->year   = date("Y", strtotime($teacher->birthday));
            $teacher->month  = date("m", strtotime($teacher->birthday));
            $teacher->day    = date("d", strtotime($teacher->birthday));
        endif;
        $teacherInformation = $this->teacherRepository
            ->findOneBy([TeacherInformationConstants::COL_TEACHER_ID => $teacher->id]);

        return Inertia::render('Teacher/Account', [
            'teacher'               => $teacher,
            'teacherInformation'    => $teacherInformation,
        ]);
    }

    public function updateAccount(TeacherAccountRequest $request)
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
            $dataUser = [
                UserConstants::COL_FIRST_NAME   => $request->first_name,
                UserConstants::COL_LAST_NAME    => $request->last_name,
                UserConstants::COL_COUNTRY_ID   => $request->country_id,
                UserConstants::COL_CITY_ID      => $request->city_id,
                // UserConstants::COL_EMAIL     => $request->email,
                UserConstants::COL_BIRTHDAY
                    => convertStringToDate($request->year, $request->month, $request->day),
            ];
            $data = [
                TeacherInformationConstants::COL_COUNTRY_CODE   => $request->country_code,
                TeacherInformationConstants::COL_PHONE          => $request->phone,
                TeacherInformationConstants::COL_JOB            => $request->job,
                TeacherInformationConstants::COL_SALARY         => $request->salary,
                TeacherInformationConstants::COL_HEADLINE       => $request->headline,
                TeacherInformationConstants::COL_ABOUT          => $request->about,
            ];
            if ($request->profile_image) :
                $profileImage = $this->fileService
                    ->storeFile(
                        $request->profile_image,
                        TeacherInformationConstants::STORAGE_PROFILE_IMAGE
                    );
                $data[TeacherInformationConstants::COL_PROFILE_IMAGE] = $domain . '/' . $profileImage;
            endif;

            if ($request->short_video_for_learner) :
                $introductionVideo = $this->fileService
                    ->storeFile(
                        $request->short_video_for_learner,
                        TeacherInformationConstants::STORAGE_INTRODUCTION_VIDEO
                    );
                $data[TeacherInformationConstants::COL_INTRODUCTION_VIDEO] = $domain . '/' . $introductionVideo;
            endif;

            $this->userRepository->update(auth()->user()->id, $dataUser);

            if ($teacherInformation = $this->teacherRepository->findOneBy([
                TeacherInformationConstants::COL_TEACHER_ID => auth()->user()->id,
            ])) {
                $this->teacherRepository->update($teacherInformation->id, $data);
            }

            return redirect()->route('teacher.account');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return void
     */
    public function deleteAccount()
    {
        try {
            $user = auth()->user();
            $checkIfUserHasCourse = $this->lessonRepository
                ->checkIfUserHasCourse($user->id);
            $checkIfUserHasCourseApply = $this->courseApplicationRepository
                ->checkIfUserHasApply($user->id);

            if ($checkIfUserHasCourse || $checkIfUserHasCourseApply) {
                throw ValidationException::withMessages([
                    'isAvailable' => false,
                ]);
            } else {
                session()->flush();
                auth()->logout();
                $user->delete();
    
                return redirect()->route('teacher.account.delete.success');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return Response
     */
    public function deleteAccountSuccess(): Response
    {
        return Inertia::render('Auth/DeleteSuccess');
    }

	public function getNotification()
	{
		return Inertia::render('Teacher/Notification', [
			'user_role' => auth()->user()->role
		]);
	}
}
