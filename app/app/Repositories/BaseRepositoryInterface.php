<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @param array $attributes
     * @param array $options
     *
     * @return mixed
     */
    public function update($id, array $attributes, array $options = []);

    /**
     * @param array $columns
     * @param $orderBy
     * @param $sortBy
     * @return mixed
     */
    public function all($columns, $orderBy, $sortBy);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneOrFail($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data, $columns);

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data);

    /**
     * @param array $data
     * @param array $relations
     * @return mixed
     */
    public function findOneByWithRelationships(array $data, array $relations = []);

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * @return bool
     */
    public function deleteAll();

    public function findByAttrFirst($attr, $value);

    public function pluckAttrId($attr);

    public function deleteByAttr($attr, $value);

    public function findByAttrInArray($attr, $array);

    public function updateOrCreateModel($data);

    public function findByWithRelationship(
        array $relations,
        array $data,
        $columns,
        $orderBy,
        $sortBy
    );

    public function getAllWithRelationship(
        $relations = [''],
        $columns = ['*'],
        $orderBy = 'id',
        $sortBy = 'asc'
    );

    public function whereIn($column, array $data, $relations);

    /*
    |--------------------------------------------------------------------------
    | Start restructure base repository
    |--------------------------------------------------------------------------
    */
    /**
     * Check the existent model.
     *
     * @param $condition
     * @param $column
     * @return bool
     */
    public function exist($column, $condition): bool;

    /**
     * Get the list with relationship
     *
     * @param array $columns
     * @param array $condition
     * @param array $other sort, relation, join, paginate
     * @return mixed
     */
    public function getList(array $columns = SELECT_ALL, array $condition = [], array $other = []): mixed;

    /**
     * Get the model detail.
     *
     * @param array $condition
     * @param array $columns
     * @param array $relations
     *
     * @return Model
     */
    public function getDetail(array $condition, array $columns = SELECT_ALL, array $relations = []): Model;

    /**
     * Delete record by id | list id
     *
     * @param array|int $id
     * @return int|null
     */
    public function delete(array|int $id): ?int;

    /**
     * Update model.
     *
     * @param Model $model
     * @param array $input
     *
     * @return Model|null
     */
    public function updates(Model $model, array $input): ?Model;
    
    /**
     * @param integer $limit
     * @param string $orderBy
     * @param string $sortBy
     * @return void
     */
    public function limitGet($limit = 1, $orderBy = 'id', $sortBy = 'DESC');
    /*
    |--------------------------------------------------------------------------
    | End restructure base repository
    |--------------------------------------------------------------------------
    */
}
