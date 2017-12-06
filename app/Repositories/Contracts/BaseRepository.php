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
     * @param  array    $with
     * @param  array    $columns
     * @return Collection
     */
    public function get(array $with = [], array $columns = ['*']);

    /**
     * Get Model from storage
     *
     * @param  mixed    $id
     * @param  array    $with
     * @return Model
     */
    public function find($id, array $with = []);

    /**
     * Get a set of Models from storage
     *
     * @param  array    $ids
     * @param  array    $with
     * @return Collection
     */
    public function findMany($ids, array $with = []);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed    $id
     * @param  array    $with
     * @return \App\BFX\Model
     *
     * @throws RuntimeException
     */
    public function findOrFail($id, array $with = []);
 
    /**
     * Get a set of Models by attribute value
     *
     * @param   string  $column
     * @param   string  $value
     * @param   array   $with
     * @param   array   $columns
     * @return mixed
     */
    public function findBy($column, $value, array $with = [], array $columns = ['*']);

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
     * @param  array    $attributes
     * @param  mixed    $id
     * @return bool
     */
    public function update(array $attributes, $id);

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
}
