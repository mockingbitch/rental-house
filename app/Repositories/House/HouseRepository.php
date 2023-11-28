<?php

namespace App\Repositories\User;

use App\Models\House;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class HouseRepository extends BaseRepository implements HouseRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return House::class;
    }
}

