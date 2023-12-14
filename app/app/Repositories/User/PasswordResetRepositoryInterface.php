<?php

namespace App\Repositories\User;

interface PasswordResetRepositoryInterface
{
    public function getUserToken($email);

    public function deleteByEmail($email);
}
