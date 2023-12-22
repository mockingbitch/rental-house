<?php

namespace App\Repositories\Request;

use App\Models\Request;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Request::class;
    }
}
