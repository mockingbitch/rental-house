<?php

namespace App\Repositories\Tag;

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

    public function findTagByName(string $tag_name)
    {
        return $this->model
            ->where('name_vi', 'like', $tag_name)
            ->orWhere('name_en', 'like', $tag_name)
            ->get()
            ->first();
    }

    public function findTagsByIDString(string $listID)
    {
        return $this->model
            ->whereRaw('id IN (' . $listID . ')')
            ->get();
    }
}
?>
