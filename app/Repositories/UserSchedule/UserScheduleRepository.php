<?php

namespace App\Repositories\UserSchedule;

use App\Models\UserSchedule;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserScheduleRepository extends BaseRepository implements UserScheduleRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return UserSchedule::class;
    }
}
