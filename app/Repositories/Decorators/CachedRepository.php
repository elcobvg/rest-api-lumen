<?php

namespace App\Repositories\Decorators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepository;

abstract class CachedRepository implements BaseRepository
{
    /**
     * Expiration time of cache in minutes
     *
     * @var integer
     */
    protected $minutes;

    /**
     * Implementation of BaseRepository
     *
     * @var BaseRepository
     */
    protected $repository;

    /**
     * The type of the resource
     *
     * @var string
     */
    protected $resourceType;

    /**
     * @inheritdoc
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
        $this->minutes = config('cache.expiration');
    }

    /**
     * @inheritdoc
     */
    public function all(array $columns = ['*'])
    {
        return Cache::remember($this->resourceType, $this->minutes, function () use ($columns) {
            return $this->repository->all($columns);
        });
    }

    /**
     * @inheritdoc
     */
    public function paginate($page = 1, array $columns = ['*'])
    {
        $key = $this->resourceType . ':page' . $page;
        return Cache::remember($key, $this->minutes, function () use ($page, $columns) {
            return $this->repository->paginate($page, $columns);
        });
    }
    
    /**
     * @inheritdoc
     */
    public function get(array $with = [], array $columns = ['*'])
    {
        if (sizeof($with)) {
            return $this->model->with(join(', ', $with))->get($columns);
        }
        return $this->model->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function find($id, array $with = [])
    {
        if (sizeof($with)) {
            return $this->model->with(join(', ', $with))->find($id);
        }
        return $this->model->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findMany($ids, array $with = [])
    {
        if (sizeof($with)) {
            return $this->model->with(join(', ', $with))->findMany($id);
        }
        return $this->model->findMany($id);
    }

    /**
     * @inheritdoc
     */
    public function findOrFail($id, array $with = [])
    {
        if (sizeof($with)) {
            return $this->model->with(join(', ', $with))->findOrFail($id);
        }
        return $this->model->findOrFail($id);
    }
 
    /**
     * @inheritdoc
     */
    public function findBy($column, $value, array $with = [], array $columns = ['*'])
    {
        if (sizeof($with)) {
            return $this->model->with(join(', ', $with))->where($column, $value)->first($columns);
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
    public function update(array $attributes, $id)
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
}
