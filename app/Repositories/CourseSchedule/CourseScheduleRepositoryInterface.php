<?php

namespace App\Repositories\CourseSchedule;

interface CourseScheduleRepositoryInterface
{
    /**
     * @param integer $course_id
     * @return Collection
     */
    public function deleteByCourseId($course_id);

    /**
     * @param array $created_schedules , $new_schedules
     * @return array
     */
    public function checkDuplicate(array $created_schedules, array $new_schedules);

    /**
     * @param array $created_schedules , $new_schedules
     * @return array
     */
    public function getLessonStartTime(array $created_schedules, array $new_schedules);

    /**
     * @param array $created_schedules , $new_schedules
     * @return array
     */
    public function getLessonEndTime(array $created_schedules, array $new_schedules);
}
