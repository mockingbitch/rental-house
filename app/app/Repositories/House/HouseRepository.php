<?php

namespace App\Repositories\House;

use App\Models\House;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class HouseRepository extends BaseRepository implements HouseRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return House::class;
    }

    public function search(array $data = [])
    {
        $query = $this->model->with(['lessor', 'rooms']);
        if (isset($data['keyword'])) :
            $query = $query->where(
                'name',
                'like',
                '%' . $data['keyword'] . '%'
            );
        endif;

        return $query->get();
    }

    public function getListSuggest(array $data = [])
    {

    }
}

