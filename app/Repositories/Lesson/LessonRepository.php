<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Constants\LessonConstants;
use App\Constants\CommonConstants;
use App\Constants\LessonCourseConstants;
use Carbon\Carbon;

class LessonRepository extends BaseRepository implements LessonRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Lesson::class;
    }

    /**
     * @return Collection
     */
    public function getListAvailable() : Collection
    {
        return $this->model
            ->where(
                LessonConstants::COL_START_DATE,
                CommonConstants::OPERATOR_GREATER_EQUAL,
                Carbon::now()->toDateString()
            )
            ->with('teacher')
            ->orderBy('lessons.created_at', 'desc')
            ->get();
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function search($data = []): Collection
    {
        $query = $this->model->with('course')->select('lessons.*')->distinct();
        if (isset($data['keyword'])) :
            $query = $query->where(
                LessonConstants::TBL_NAME . '.' . LessonConstants::COL_TITLE,
                CommonConstants::OPERATOR_LIKE,
                '%'.$data['keyword'].'%'
            );
        endif;
        if (isset($data['age'])) :
            $query = $query->where(
                LessonConstants::COL_TARGET_AGE_FROM,
                CommonConstants::OPERATOR_LESS_EQUAL,
                $data['age']
            )
                ->where(
                    LessonConstants::COL_TARGET_AGE_TO,
                    CommonConstants::OPERATOR_GREATER_EQUAL,
                    $data['age']
                );
        endif;
        if (isset($data['start_date'])) :
            $query = $query->where(
                LessonConstants::COL_START_DATE,
                CommonConstants::OPERATOR_GREATER_EQUAL,
                date_format(date_create($data['start_date']), CommonConstants::DATE_FORMAT_YMD)
            );
        endif;
        if (isset($data['end_date'])) :
            $query = $query->where(
                LessonConstants::COL_END_DATE,
                CommonConstants::OPERATOR_LESS_EQUAL,
                date_format(date_create($data['end_date']), CommonConstants::DATE_FORMAT_YMD)
            );
        endif;
        if (isset($data['start_price_range'])) {
            $query = $query->where(
                LessonConstants::COL_PRICE,
                CommonConstants::OPERATOR_GREATER_EQUAL,
                (int) $data['start_price_range']
            );
        }
        if (isset($data['finish_price_range'])) {
            $query = $query->where(
                LessonConstants::COL_PRICE,
                CommonConstants::OPERATOR_LESS_EQUAL,
                (int) $data['finish_price_range']
            );
        }
        if (isset($data['start_time']) || isset($data['end_time']) || isset($data['day'])) :
            $query = $query->join(
                LessonCourseConstants::TBL_NAME,
                LessonCourseConstants::TBL_NAME . '.' . LessonCourseConstants::COL_LESSON_ID,
                CommonConstants::OPERATOR_EQUAL,
                LessonConstants::TBL_NAME . '.' . LessonConstants::COL_ID
            );
        endif;
        if (isset($data['start_time'])) :
            $query = $query
                ->where(
                    LessonCourseConstants::COL_START_TIME,
                    CommonConstants::OPERATOR_GREATER_EQUAL,
                    date("H:i:s", strtotime($data['start_time']))
                );
        endif;
        if (isset($data['end_time'])) :
            $query = $query
                ->where(
                    LessonCourseConstants::COL_END_TIME,
                    CommonConstants::OPERATOR_LESS_EQUAL,
                    date("H:i:s", strtotime($data['end_time']))
                );
        endif;
        if (isset($data['day'])) :
            $query = $query->where(function ($query) use ($data) {
                foreach ($data['day'] as $day) :
                    $query->orWhere(
                        LessonCourseConstants::COL_WEEKDAY,
                        CommonConstants::OPERATOR_LIKE,
                        '%'. $day . '%'
                    );
                endforeach;
            });
            // dd($query->get());
        endif;

        return $query
            ->where(
                LessonConstants::COL_END_DATE,
                CommonConstants::OPERATOR_GREATER_EQUAL,
                Carbon::now()
            )
            ->orderBy(LessonConstants::COL_START_DATE, CommonConstants::ORDER_ASC)
            ->get();
    }

    /**
     * @return Collection
     */
    public function suggest(): Collection
    {
        return $this
            ->model
            ->orderBy(LessonConstants::COL_VIEW, CommonConstants::ORDER_DESC)
            ->where(
                LessonConstants::COL_END_DATE,
                CommonConstants::OPERATOR_GREATER_EQUAL,
                Carbon::now()
            )
            ->get();
    }

    /**
     * @return Collection
     */
    public function getListLesson($teacher_id) : Collection
    {
        return $this->model
            ->where(LessonConstants::COL_TEACHER_ID, $teacher_id)
            ->orderBy('lessons.created_at', 'desc')
            ->get();
    }

    /**
     * @return array
     */
    public function getListSchedule($teacher_id, $status)
    {
        $listSchedule = [];
        $lessons = $this->model->where(LessonConstants::COL_TEACHER_ID, $teacher_id)->get();

        foreach ($lessons as $lesson) :
            foreach ($lesson->course as $course) :
                foreach ($course->course_schedules as $schedule) :
                    if ($status == 'array') :
                        $listSchedule[] = [
                            "date"          => Carbon::parse($schedule->date)->format('Y/m/d'),
                            "start_time"    => Carbon::parse($schedule->date." ".Carbon::parse($schedule->start_time)->format('H:i:s')),
                            "end_time"      => Carbon::parse($schedule->date." ".Carbon::parse($schedule->end_time)->format('H:i:s')),
                        ];
                    else :
                        $schedule->compare = Carbon::parse($schedule->date." ".Carbon::parse($schedule->start_time)->format('H:i:s'));
                        $listSchedule[] = $schedule;
                    endif;
                endforeach;
            endforeach;
        endforeach;

        return $listSchedule;
    }

    public function getLessontSchedule($lesson_id)
    {
        $scheduleArray = [];
        $lessons = $this->model->find($lesson_id);

        foreach ($lessons->course as $course):
            foreach ($course->course_schedules as $schedule):
                $scheduleArray[] = [
                    "date"          => Carbon::parse($schedule->date)->format('Y/m/d'),
                    "start_time"    => Carbon::parse($schedule->date." ".Carbon::parse($schedule->start_time)->format('H:i:s')),
                    "end_time"      => Carbon::parse($schedule->date." ".Carbon::parse($schedule->end_time)->format('H:i:s')),
                ];
            endforeach;
        endforeach;

        return $scheduleArray;
    }

    /**
     * @param integer|null $id
     * @return boolean
     */
    public function checkIfUserHasCourse(?int $id): bool
    {
        $courseApplications = $this->model
            ->join('lesson_courses', 'lesson_courses.lesson_id', '=', 'lessons.id')
            ->join('course_applications', 'course_applications.course_id', '=', 'lesson_courses.id')
            ->where('lessons.teacher_id', $id)
            ->where('lessons.status', '1')
            ->where('lesson_courses.status', '1')
            ->where('course_applications.status', '1')
            ->select('course_applications.*')->get();
        // $lessons = $this->model->where([
        //     LessonConstants::COL_TEACHER_ID => $id,
        //     LessonConstants::COL_STATUS     => '1',
        // ])->get();
        
        return count($lessons) > 0 ? true : false;
    }
}
