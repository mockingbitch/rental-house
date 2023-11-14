<?php

namespace App\Repositories\User;

use App\Models\Room;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Room::class;
    }
}

