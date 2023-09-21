<?php

namespace App\Repositories\CourseApplication;

use App\Models\CourseApplication;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\LessonCourseConstants;
use App\Constants\CourseApplicationConstants;

class CourseApplicationRepository extends BaseRepository implements CourseApplicationRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return CourseApplication::class;
    }

    /**
     * @param integer|null $id
     * @return boolean
     */
    public function checkIfUserHasApply(?int $id): bool
    {
        $applied = $this->model->where([
            CourseApplicationConstants::COL_USER_ID => $id,
            CourseApplicationConstants::COL_STATUS  => '1',
        ])->get();

        return count($applied) > 0 ? true : false;
    }
}
