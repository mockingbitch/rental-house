<?php

namespace App\Repositories\LessonView;

use App\Models\View;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\ViewConstants;

class ViewRepository extends BaseRepository implements ViewRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return View::class;
    }

    public function checkUserAgent($user_agent, $lesson_id)
    {
        return  $this->model
                    ->where(ViewConstants::COL_USER_AGENT, $user_agent)
                    ->where(ViewConstants::COL_LESSON_ID, $lesson_id)
                    ->first();
    }
}