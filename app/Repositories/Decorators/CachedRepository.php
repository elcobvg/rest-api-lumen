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
        return Cache::remember($this->cacheKey(), $this->minutes, function () use ($columns) {
            return $this->repository->all($columns);
        });
    }

    /**
     * @inheritdoc
     */
    public function paginate($page = 1, array $columns = ['*'])
    {
        $key = $this->cacheKey() . ':page:' . $page;
        return Cache::remember($key, $this->minutes, function () use ($page, $columns) {
            return $this->repository->paginate($page, $columns);
        });
    }
    
    /**
     * @inheritdoc
     */
    public function get(array $columns = ['*'])
    {
        return Cache::remember($this->cacheKey(), $this->minutes, function () use ($columns) {
            return $this->repository->get($columns);
        });
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        $key = $this->cacheKey() . ':id:' . $id;
        return Cache::remember($key, $this->minutes, function () use ($id) {
            return $this->repository->find($id);
        });
    }

    /**
     * @inheritdoc
     */
    public function findMany($ids)
    {
        $key = $this->cacheKey() . ':ids:' . implode(':', $ids);
        return Cache::remember($key, $this->minutes, function () use ($ids) {
            return $this->repository->findMany($ids);
        });
    }

    /**
     * @inheritdoc
     */
    public function findOrFail($id)
    {
        return $this->repository->findOrFail($id);
    }
 
    /**
     * @inheritdoc
     */
    public function findBy($column, $value, array $columns = ['*'])
    {
        return $this->repository->findBy($column, $value, $columns);
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    /**
     * @inheritdoc
     */
    public function save(array $data)
    {
        return $this->repository->save($attributes);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $attributes)
    {
        return $this->repository->update($model, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function updateById(array $attributes, $id)
    {
        return $this->repository->update($attributes, $id);
    }

    /**
     * @inheritdoc
     */
    public function updateWhere(array $attributes, $column, $value)
    {
        return $this->repository->updateWhere($attributes, $column, $value);
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id, $force = false)
    {
        return $this->repository->deleteById($id, $force);
    }

    /**
     * @inheritdoc
     */
    public function deleteWhere($column, $value, $force = false)
    {
        return $this->repository->deleteWhere($column, $value, $force);
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $this->repository->delete($model);
    }

    /**
     * @inheritdoc
     */
    public function with($relations)
    {
        return $this->repository->with($relations);
    }

    /**
     * Make cache key with relation attributes
     *
     */
    protected function cacheKey()
    {
        $key = $this->resourceType();
        if ($with = $this->repository->getRelations()) {
            $key .= ':with:' . implode(':', $with);
        }
        return $key;
    }

    /**
     * Get the resource type
     * @return  string
     */
    public function resourceType()
    {
        return $this->repository->resourceType();
    }
}
