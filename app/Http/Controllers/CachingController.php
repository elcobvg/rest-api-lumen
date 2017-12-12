<?php

namespace App\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\JsonApiSerializer;
use App\Extensions\IlluminatePaginatorAdapter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class CachingController extends Controller
{
    /**
     * Expiration time of cache in minutes
     *
     * @var integer
     */
    protected $minutes;

    /**
     * Constructor
     *
     * @param TransformerAbstract $transformer
     */
    public function __construct(TransformerAbstract $transformer)
    {
        $this->minutes = config('cache.expiration');
        parent::__construct($transformer);
    }

    /**
     * Return collection response from the application
     *
     * @param array|LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection $collection
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection)
    {
        $key = ($collection instanceof LengthAwarePaginator)
                ? $this->resourceType . ':page:' . $collection->currentPage()
                : $this->resourceType;
                
        $data = Cache::remember($key, $this->minutes, function () use ($collection) {
            return $this->createDataCollection($collection);
        });

        return $this->respondWithArray($data);
    }

    /**
     * Return single item response from the application
     *
     * @param Model $item
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem(Model $item)
    {
        $key = $this->resourceType . ':id:' . $item->getKey();
        $data = Cache::remember($key, $this->minutes, function () use ($item) {
            return $this->createDataItem($item);
        });

        return $this->respondWithArray($data);
    }
}
