<?php

namespace App\Repositories\LessonCourse;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface LessonCourseRepositoryInterface
{
    /**
    * @return object
    */
    public function getScheduleApplications($lesson_id);

    /**
    * @return array
    */
    public function getSchedule(int $total, array $weekday, Carbon $startDate);

        /**
     * @param array $teachers
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    public function getScheduleForTeacher($teachers = [], $startDate = '', $endDate = ''): array;

    /**
     * @param array $teachers
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    public function getScheduleHourForTeacher($teachers = [], $time = '', $date = ''): array;
}
