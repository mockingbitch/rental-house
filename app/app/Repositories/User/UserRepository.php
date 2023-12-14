<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return User::class;
    }

    public function findUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updateUserByEmail($email, array $attributes)
    {
        return $this->model->where('email', $email)->update($attributes);
    }
}
