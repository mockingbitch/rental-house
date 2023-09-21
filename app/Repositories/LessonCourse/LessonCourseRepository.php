<?php

namespace App\Repositories\LessonCourse;

use App\Models\LessonCourse;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\LessonCourseConstants;
use App\Constants\LessonConstants;
use App\Constants\CourseScheduleConstants;
use App\Constants\CommonConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Collection;

class LessonCourseRepository extends BaseRepository implements LessonCourseRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return LessonCourse::class;
    }

    /**
    * @return object
    */
    public function getScheduleApplications($lesson_id): object
    {
        return $this->model
                    ->select(DB::raw('lesson_courses.*, COUNT(application_details.id) AS total_applied'))
                    ->leftJoin('course_applications', function (JoinClause $join) {
                        $join->on('course_applications.course_id', '=', 'lesson_courses.id')
                            ->where('course_applications.status', '=', '1');
                    })
                    ->leftJoin('application_details', function (JoinClause $join) {
                        $join->on('application_details.application_id', '=', 'course_applications.id')
                            ->where('application_details.status', '=', '1');
                    })
                    ->where('lesson_courses.lesson_id', '=', $lesson_id)
                    ->groupBy('lesson_courses.id')
                    ->get();
    }

    /**
    * @return array
    */
    public function getSchedule(int $total, array $weekday, Carbon $startDate): array
    {
        $result = [];
        $count = 0;
        $weekMap = [
            0 => 8,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
        ];
        while ($count <= $total) {
            $dayOfWeek = $startDate->dayOfWeek;
            $thu = $weekMap[$dayOfWeek];
            if (in_array($thu, $weekday)) {
                $result[] = $startDate->format('Y-m-d');
                $count++;
            }
            $startDate = $startDate->addDay();
        }
        return $result;
    }

    /**
     * @param array $teachers
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    public function getScheduleForTeacher($teachers = [], $startDate = '', $endDate = ''): array
    {
        $listSchedule = [];
        foreach ($teachers as $teacher) :
            $courseSchedules = $this->model
                ->join(
                    LessonConstants::TBL_NAME,
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_ID,
                    CommonConstants::OPERATOR_EQUAL,
                    LessonCourseConstants::TBL_NAME . '.' . LessonCourseConstants::COL_LESSON_ID
                    )
                ->join(
                    CourseScheduleConstants::TBL_NAME,
                    CourseScheduleConstants::TBL_NAME . '.' . CourseScheduleConstants::COL_COURSE_ID,
                    CommonConstants::OPERATOR_EQUAL,
                    LessonCourseConstants::TBL_NAME . '.' . LessonCourseConstants::COL_ID
                    )
                ->select(
                    CourseScheduleConstants::TBL_NAME . '.*',
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TEACHER_ID,
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TITLE
                    )
                ->where(
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TEACHER_ID,
                    $teacher->id
                    )
                ->whereBetween(
                    CourseScheduleConstants::TBL_NAME . '.' . CourseScheduleConstants::COL_DATE,
                    [
                        date($startDate),
                        date($endDate)
                    ]
                    )
                ->get();
            foreach ($courseSchedules as $schedule) :
                if ($schedule) :
                    $listSchedule[] = $schedule;
                endif;
            endforeach;
        endforeach;

        return $listSchedule;
    }

    /**
     * @param array $teachers
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    public function getScheduleHourForTeacher($teachers = [], $time = '', $date = ''): array
    {
        $listSchedule = [];
        foreach ($teachers as $teacher) :
            $courseSchedules = $this->model
                ->join(
                    LessonConstants::TBL_NAME,
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_ID,
                    CommonConstants::OPERATOR_EQUAL,
                    LessonCourseConstants::TBL_NAME . '.' . LessonCourseConstants::COL_LESSON_ID
                    )
                ->join(
                    CourseScheduleConstants::TBL_NAME,
                    CourseScheduleConstants::TBL_NAME . '.' . CourseScheduleConstants::COL_COURSE_ID,
                    CommonConstants::OPERATOR_EQUAL,
                    LessonCourseConstants::TBL_NAME . '.' . LessonCourseConstants::COL_ID
                    )
                ->select(
                    CourseScheduleConstants::TBL_NAME . '.*',
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TEACHER_ID,
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TITLE
                    )
                ->where(
                    LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TEACHER_ID,
                    $teacher->id
                    )
                ->where(
                    CourseScheduleConstants::TBL_NAME . '.' . CourseScheduleConstants::COL_DATE,
                    $date
                )
                ->where(DB::raw("DATE_FORMAT(course_schedules.start_time, '%H:%i')"), '=', $time)
                ->get();
            foreach ($courseSchedules as $schedule) :
                if ($schedule) :
                    $listSchedule[] = $schedule;
                endif;
            endforeach;
        endforeach;

        return $listSchedule;
    }
}
