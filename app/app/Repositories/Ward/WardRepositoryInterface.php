<?php

namespace App\Repositories\Ward;

use App\Repositories\BaseRepositoryInterface;

interface WardRepositoryInterface
{
    public function all($columns = ['*'], $orderBy = 'code', $sortBy = 'asc');
}
