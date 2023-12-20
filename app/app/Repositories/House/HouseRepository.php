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

    /**
     * @param array $data
     * @return mixed
     */
    public function search(array $data = []): mixed
    {
        $query = $this->model
            ->select('houses.*')
            ->distinct()
            ->with(['lessor', 'rooms', 'category']);
        if (isset($data['keyword'])) :
            $query = $query->where(
                'houses.name',
                'like',
                '%' . $data['keyword'] . '%'
            );
        endif;
        if (isset($data['ward_code'])) :
            $query = $query->where('ward_code', $data['ward_code']);
        elseif(isset($data['district_code'])) :
            $query = $query->where('district_code', $data['district_code']);
        elseif (isset($data['province_code'])) :
            $query = $query->where('province_code', $data['province_code']);
        endif;
        if (isset($data['category_id'])) :
            $query = $query->where(
                'houses.category_id',
                $data['category_id']
            );
        endif;
        if (
            isset($data['start_price_range'])
            || isset($data['finish_price_range'])
        ) :
            $query = $query->join('rooms', 'rooms.house_id', '=', 'houses.id');
            if (isset($data['start_price_range'])) :
                $query = $query->where(
                    'rooms.price',
                    '>=',
                    $data['start_price_range']
                );
            endif;
            if (isset($data['finish_price_range'])) :
                $query = $query->where(
                    'rooms.price',
                    '<=',
                    $data['finish_price_range']
                );
            endif;
        endif;

        return $query
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}

