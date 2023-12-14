<?php

namespace App\Repositories\User;

use App\Models\PasswordReset;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return PasswordReset::class;
    }

    public function getUserToken($email)
    {
        return $this->model->where('email', $email)->first()->token;
    }

    public function deleteByEmail($email)
    {
        return $this->model->where('email', $email)->delete();
    }
}
