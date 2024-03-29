<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function findUserByEmail($email);

    public function updateUserByEmail($email, array $attributes);
}
