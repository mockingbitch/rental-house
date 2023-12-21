<?php

namespace App\Repositories\Ward;

use App\Models\Address\Ward;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Ward::class;
    }

    public function all($columns = ['*'], $orderBy = 'code', $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }
}
