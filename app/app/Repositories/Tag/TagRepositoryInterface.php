<?php

namespace App\Repositories\Tag;

interface TagRepositoryInterface
{
    public function findTagByName(string $tag_name);

    public function findTagsByIDString(string $listID);
}
