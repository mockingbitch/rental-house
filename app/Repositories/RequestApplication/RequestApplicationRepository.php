<?php

namespace App\Repositories\RequestApplication;

use App\Models\RequestApplication;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RequestApplicationRepository extends BaseRepository implements RequestApplicationRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return RequestApplication::class;
    } 
}
