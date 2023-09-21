<?php

namespace App\Repositories\Material;

use App\Models\Material;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class MaterialRepository extends BaseRepository implements MaterialRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Material::class;
    }
}