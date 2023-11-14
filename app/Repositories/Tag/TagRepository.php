<?php

namespace App\Repositories\User;

use App\Models\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Tag::class;
    }
}
?>
