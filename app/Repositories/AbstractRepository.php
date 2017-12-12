<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepository;

abstract class AbstractRepository implements BaseRepository
{
    /**
     * Instance that extends Illuminate\Database\Eloquent\Model
     *
     * @var Model
     */
    protected $model;

    /**
     * The relations to eager load.
     *
     * @var array
     */
    protected $with = [];

    /**
     * @inheritdoc
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function paginate($page = 1, array $columns = ['*'])
    {
        return $this->model->paginate($this->model->getPerPage(), $columns);
    }
    
    /**
     * @inheritdoc
     */
    public function get(array $columns = ['*'])
    {
        if ($this->with) {
            return $this->model->with($this->with)->get($columns);
        }
        return $this->model->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        if ($this->with) {
            return $this->model->with($this->with)->find($id);
        }
        return $this->model->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findMany($ids)
    {
        if ($this->with) {
            return $this->model->with($this->with)->findMany($ids);
        }
        return $this->model->findMany($ids);
    }

    /**
     * @inheritdoc
     */
    public function findOrFail($id)
    {
        if ($this->with) {
            return $this->model->with($this->with)->findOrFail($id);
        }
        return $this->model->findOrFail($id);
    }
 
    /**
     * @inheritdoc
     */
    public function findBy($column, $value, array $columns = [])
    {
        if ($this->with) {
            return $this->model->with($this->with)->where($column, $value)->first($columns);
        }
        return $this->model->where($column, $value)->first($columns);
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes)
    {
        return $this->save($attributes);
    }

    /**
     * @inheritdoc
     */
    public function save(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $attributes)
    {
        return $model->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function updateById(array $attributes, $id)
    {
        return $this->model->whereKey($id)->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function updateWhere(array $attributes, $column, $value)
    {
        return $this->model->where($column, $value)->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id, $force = false)
    {
        return $force   ? $this->model->find($id)->forceDelete()
                        : $this->model->find($id)->delete();
    }

    /**
     * @inheritdoc
     */
    public function deleteWhere($column, $value, $force = false)
    {
        return $force   ? $this->model->where($column, $value)->forceDelete()
                        : $this->model->where($column, $value)->delete();
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * @inheritdoc
     */
    public function with($relations)
    {
        $this->with = is_string($relations) ? func_get_args() : $relations;
        return $this;
    }

    /**
     * Get array of relations to be loaded
     * @return array
     */
    public function getRelations()
    {
        return $this->with;
    }

    /**
     * Get the resource type
     * @return  string
     */
    public function resourceType()
    {
        return kebab_case(str_plural(class_basename($this->model)));
    }
}
