<?php

namespace App\Repositories\Kid;

interface KidRepositoryInterface
{
    /**
     * @param integer $parent_id
     * @param array $data
     * @return bool
     */
    public function createKidInformation(int $parent_id, array $data = []): bool;

    /**
     * @param integer $parent_id
     * @param array $data
     * @return mixed
     */
    public function createKidIfNotExist(int $parent_id, array $data = []);
}
