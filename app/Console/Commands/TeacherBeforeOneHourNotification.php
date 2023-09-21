<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\LessonCourse\LessonCourseRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\NotificationService;
use App\Constants\NotificationConstants;
use Carbon\Carbon;

class TeacherBeforeOneHourNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificationteacher:beforeonehourcourse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for teacher. Announcing course before 1 hour';

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
        $time       = Carbon::now()->addHour()->format('H:i');
        $date       = Carbon::now()->format('y-m-d');
        $listSchedule = $this->lessonCourseRepository->getScheduleHourForTeacher($teachers, $time, $date);
        foreach ($listSchedule as $schedule) :
            $teacher = $this->userRepository->findOneBy(['id' => $schedule->teacher_id]);
            $this->notificationService
                ->sendNotification(
                    $teacher,
                    [
                        'title'     => '1時間後にレッスンが始まります。準備をしてください。
                        ' . $schedule->date . ' ' . $schedule->start_time->format('H:i') . ' ' . $schedule->title,
                        'target'    => route('schedule.list'),
                    ],
                    NotificationConstants::BROADCAST_TEACHER,
                );
        endforeach;

        return Command::SUCCESS;
    }
}
