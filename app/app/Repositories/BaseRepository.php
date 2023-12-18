<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Constants\CommonConstants;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;
    protected $modelClass;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct()
    {
        $this->setModel();
    }

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
        $this->modelClass = app()->make($this->getModel());
    }

    abstract public function getModel();

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param [type] $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $result = $this->find($id);
        if (!$result) {
            return false;
        }
        $result->update($data);
        return $result;
    }

    /**
     * @param array $columns
     * @param $orderBy
     * @param $sortBy
     * @return mixed
     */
    public function all($columns = ['*'], $orderBy = 'id', $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param  $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function findBy(array $data, $columns = '*')
    {
        return $this->model->where($data)->orderBy('created_at', 'DESC')->get($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @param array $relations
     * @return mixed
     */
    public function findOneByWithRelationships(array $data, array $relations = [] )
    {
        if (empty($relations)):
            return $this->model->where($data)->first();
        else:
            return $this->model->with($relations)->where($data)->first();
        endif;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteAll(): bool
    {
        return $this->model->delete();
    }

    public function findByAttrFirst($attr, $value)
    {
        return !is_null($attr) ? $this->modelClass::where($attr, $value)->first() : null;
    }

    public function pluckAttrId($attr)
    {
        return !is_null($attr) ? $this->modelClass::pluck($attr, 'id')->all() : collect([]);
    }

    public function deleteByAttr($attr, $value)
    {
        return !is_null($attr) ? $this->modelClass::where($attr, $value)->delete() : false;
    }

    public function findByAttrInArray($attr, $array)
    {
        return !is_null($attr) ? $this->modelClass::whereIn($attr, $array)->get() : collect([]);
    }

    public function updateOrCreateModel($data)
    {
        return !is_null($data) ? $this->modelClass::updateOrCreate($data) : false;
    }

    public function arrayAttrId($attr)
    {
        return !is_null($attr) ? $this->model::pluck($attr, 'id')->toArray() : [];
    }

    public function getAllWithRelationship(
        $relations = [''],
        $columns = ['*'],
        $orderBy = 'id',
        $sortBy = 'asc'
    )
    {
        return $this->model->with($relations)->orderBy($orderBy, $sortBy)->get($columns);
    }

    public function orderBy($orderBy, $sortBy, $data)
    {
        return $this->model->where($data)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * @param array $relations
     * @param array $data
     * @param string $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection|array
     */
    public function findByWithRelationship(
        array $relations,
        array $data,
        string $columns = '*',
        string $orderBy = 'id',
        string $sortBy = 'desc'
    ): Collection|array
    {
        return $this->model->with($relations)
            ->where($data)
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    public function whereIn($column, array $data, $relations)
    {
        return $this->model->with($relations)->whereIn($column, $data)->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Start restructure base repository
    |--------------------------------------------------------------------------
    */

    /**
     * Get the name of model.
     *
     */
    public function getTable(): string
    {
        return $this->model->getTable();
    }

    /**
     * Check the existent model.
     *
     * @param $condition
     * @param $column
     * @return bool
     */
    public function exist($column, $condition): bool
    {
        return $this->model->where($column, $condition)->exists();
    }

    /**
     * Move item to the last index of array.
     *
     * @param array $input
     * @param $key
     * @return array
     */
    public static function moveItemToLast(array $input, $key): array
    {
        if (count($input) > 1 && array_key_exists($key, $input)) {
            $valueOfKeyInArray = $input[$key];
            unset($input[$key]);
            $input += [
                $key => $valueOfKeyInArray
            ];
        }

        return $input;
    }

    /**
     * Sort the list of models.
     *
     * @param Builder $query
     * @param array $sort
     * @return Builder
     */
    protected function sort(Builder $query, array $sort): Builder
    {
        foreach ($sort as $column => $value) {
            $query->orderBy($column, $value);
        }

        return $query;
    }

    /**
     * Filter models.
     *
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    protected function filter(Builder $query, array $filter): Builder
    {
        return $query->filter($filter);
    }

    /**
     * Delete record by id | list id
     *
     * @param array|int $id
     * @return int|null
     */
    public function delete(array|int $id): ?int
    {
        try {
            $query = $this->model->destroy($id);
            // Count equal to 0
            if (empty($query)) {
                $query = null;
            }
        } catch (\Exception $exception) {
            //Todo Log::error('[Delete]: ' . $exception->getMessage());
            $query = null;
        }

        return $query;
    }

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $input
     *
     * @return Model|null
     */
    public function updates(Model $model, array $input): ?Model
    {
        try {
            foreach ($input as $attribute => $value) {
                $model->{$attribute} = $value;
            }
            if ($model->isDirty()) {
                $model->save();
            }
        } catch (\Exception $exception) {
            //Todo Log::error('[Update]: ' . $exception->getMessage());
            $model = null;
        }

        return $model;
    }

    /**
     * @param integer $limit
     * @param string $orderBy
     * @param string $sortBy
     * @return void
     */
    public function limitGet($limit = 1, $orderBy = 'id', $sortBy = 'DESC')
    {
        return $this->model->limit($limit)->orderBy($orderBy, $sortBy)->get();
    }

    /*
    |--------------------------------------------------------------------------
    | End restructure base repository
    |--------------------------------------------------------------------------
    */
}
