<?php

namespace App\Repositories\ApplicationDetail;

use App\Models\ApplicationDetail;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class ApplicationDetailRepository extends BaseRepository implements ApplicationDetailRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return ApplicationDetail::class;
    }

    public function totalLearnerApplied($teacher_id)
    {
        return $this->model
                    ->select(DB::raw('application_details.updated_at, application_details.created_at, application_details.status, lessons.price, lessons.style, lessons.id'))
                    ->join('course_applications', function (JoinClause $join) {
                        $join->on('application_details.application_id', '=', 'course_applications.id');
                    })
                    ->join('lesson_courses', function (JoinClause $join) {
                        $join->on('course_applications.course_id', '=', 'lesson_courses.id');
                    })
                    ->join('lessons', function (JoinClause $join) use ($teacher_id) {
                        $join->on('lesson_courses.lesson_id', '=', 'lessons.id')
                            ->where('lessons.teacher_id', "=", $teacher_id);
                    })
                    ->get();
    }
}