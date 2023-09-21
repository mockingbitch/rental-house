<?php

namespace App\Repositories\TeacherInformation;

use App\Models\TeacherInformation;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TeacherInformationRepository extends BaseRepository implements TeacherInformationRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return TeacherInformation::class;
    }
}
