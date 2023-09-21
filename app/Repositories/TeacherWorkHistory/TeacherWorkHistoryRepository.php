<?php

namespace App\Repositories\TeacherWorkHistory;

use App\Models\TeacherWorkHistory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TeacherWorkHistoryRepository extends BaseRepository implements TeacherWorkHistoryRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return TeacherWorkHistory::class;
    }
}
