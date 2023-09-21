<?php

namespace App\Repositories\Request;

use Illuminate\Database\Eloquent\Collection;

interface RequestRepositoryInterface
{
    /**
     * @param int $teacher_id
     * @return Collection
     */
    public function getRequestApplied($teacher_id);

    /**
     * @param array $data
     * @param string $columns
     * @return Collection
     */
    public function getRequests(array $data, $columns = '*'): Collection;
}
