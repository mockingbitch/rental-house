<?php

namespace App\Repositories\CourseSchedule;

use App\Models\CourseSchedule;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CourseScheduleRepository extends BaseRepository implements CourseScheduleRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return CourseSchedule::class;
    }

    public function deleteByCourseId($course_id)
    {
        $schedule_delete = $this->model->where('course_id', $course_id)->delete();

        return $schedule_delete;
    }

    public function checkDuplicate(array $created_schedules, array $new_schedules)
    {
        $new_schedule_array = [];
        foreach ($new_schedules as $new_schedule) :
            $new_schedule['start_time'] = Carbon::parse($new_schedule['date']." ".Carbon::parse($new_schedule['start_time'])->format('H:i:s'));
            $new_schedule['end_time'] = Carbon::parse($new_schedule['date']." ".Carbon::parse($new_schedule['end_time'])->format('H:i:s'));
            $new_schedule_array[] = $new_schedule;
        endforeach;

        $duplicates = [];
        $new_array = array_merge($new_schedule_array, $created_schedules);

        for ($i = 0; $i <= count($new_array); $i++) :
            $schedule = $new_array[0];
            array_splice($new_array, 0, 1);

            for ($j = 0; $j < count($new_array); $j++) :
                if (!($schedule['end_time']->lte($new_array[$j]['start_time']) || $schedule['start_time']->gte($new_array[$j]['end_time']))) :
                    $duplicates[] = $schedule;
                endif;
            endfor;
        endfor;

        return $duplicates;
    }

    public function getLessonStartTime(array $created_schedules, array $new_schedules)
    {
        $new_array = array_merge($new_schedules, $created_schedules);
        $sortAsc = array_values(collect($new_array)->sortBy('date')->all());

        return $sortAsc[0]['date'];
    }

    public function getLessonEndTime(array $created_schedules, array $new_schedules)
    {
        $new_array = array_merge($new_schedules, $created_schedules);
        $sortDesc = array_values(collect($new_array)->sortByDesc('date')->all());

        return $sortDesc[0]['date'];
    }
}
