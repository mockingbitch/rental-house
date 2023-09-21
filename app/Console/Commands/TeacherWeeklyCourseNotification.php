<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\NotificationService;
use App\Constants\NotificationConstants;
use Carbon\Carbon;

class TeacherWeeklyCourseNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificationteacher:weeklycourse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for teacher. Announcing this weeks lesson';

    /**
     * @param LessonCourseRepositoryInterface $lessonCourseRepository
     * @param UserRepositoryInterface $userRepository
     * @param NotificationService $notificationService
     */
    public function __construct(
        public LessonCourseRepositoryInterface $lessonCourseRepository,
        public UserRepositoryInterface $userRepository,
        public NotificationService $notificationService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $teachers   = $this->userRepository->all();
        $startDate  = Carbon::today();
        $endDate    = Carbon::today()->addDays(7);
        $listSchedule = $this->lessonCourseRepository
            ->getScheduleForTeacher($teachers, $startDate, $endDate);
        foreach ($listSchedule as $schedule) :
            $teacher = $this->userRepository->findOneBy(['id' => $schedule->teacher_id]);
            $this->notificationService
                ->sendNotification(
                    $teacher,
                    [
                        'title'     => '今週の開催レッスン一覧はこちらです。
                        ' . $schedule->date . ' ' . $schedule->start_time->format('H:i') . ' ' . $schedule->title,
                        'target'    => route('schedule.list'),
                    ],
                    NotificationConstants::BROADCAST_TEACHER,
                );
        endforeach;

        return Command::SUCCESS;
    }
}
