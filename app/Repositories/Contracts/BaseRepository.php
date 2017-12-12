<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepository
{
    /**
     * Get all Models from storage
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']);

    /**
     * Get paginated Models from storage
     *
     * @param int $page
     * @param array $columns
     * @return mixed
     */
    public function paginate($page = 1, array $columns = ['*']);
    
    /**
     * Get all Models from storage with relationships
     *
     * @param  array    $columns
     * @return Collection
     */
    public function get(array $columns = ['*']);

    /**
     * Get Model from storage
     *
     * @param  mixed    $id
     * @return Model
     */
    public function find($id);

    /**
     * Get a set of Models from storage
     *
     * @param  array    $ids
     * @return Collection
     */
    public function findMany($ids);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed    $id
     * @return \App\BFX\Model
     *
     * @throws RuntimeException
     */
    public function findOrFail($id);
 
    /**
     * Get a set of Models by attribute value
     *
     * @param   string  $column
     * @param   string  $value
     * @param   array   $columns
     * @return mixed
     */
    public function findBy($column, $value, array $columns = ['*']);

    /**
     * Create and save a new Model in storage
     *
     * @param  array    $attributes
     * @return Model
     */
    public function create(array $attributes);

    /**
     * Create and save a new Model in storage (alias)
     *
     * @param  array    $attributes
     * @return Model
     */
    public function save(array $attributes);

    /**
     * Update a Model with new data
     *
     * @param  Model    $model
     * @param  array    $attributes
     * @return bool
     */
    public function update(Model $model, array $attributes);

    /**
     * Update a Model with new data by id
     *
     * @param  array    $attributes
     * @param  mixed    $id
     * @return bool
     */
    public function updateById(array $attributes, $id);

    /**
     * Update Models with new data, by a where condition
     *
     * @param  array    $attributes
     * @param  string   $column
     * @param  string   $value
     * @return bool
     */
    public function updateWhere(array $attributes, $column, $value);

    /**
     * Delete a Model and all related data
     *
     * @param  mixed    $id
     * @param  bool     $force
     * @return bool
     */
    public function deleteById($id, $force = false);

    /**
     * Delete Models and related data, by a where condition
     *
     * @param  string   $column
     * @param  string   $value
     * @param  bool     $force
     * @return bool
     */
    public function deleteWhere($column, $value, $force = false);

    /**
     * Delete a Model and all related data
     *
     * @param  Model    $model
     * @return bool
     */
    public function delete(Model $model);


    /**
     * Query the resource repository with eager loading.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function with($relations);
}
