<?php

namespace App\Repositories\CourseApplication;

interface CourseApplicationRepositoryInterface
{
    /**
     * @param integer|null $id
     * @return boolean
     */
    public function checkIfUserHasApply(?int $id): bool;
}
