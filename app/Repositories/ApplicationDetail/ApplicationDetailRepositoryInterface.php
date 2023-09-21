<?php

namespace App\Repositories\ApplicationDetail;

interface ApplicationDetailRepositoryInterface
{
    /**
     * @param integer $teacher_id
     * @param array $data
     * @return Collection
     */
    public function totalLearnerApplied($teacher_id);
}