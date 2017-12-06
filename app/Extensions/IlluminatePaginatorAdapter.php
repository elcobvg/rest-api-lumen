<?php

namespace App\Extensions;

use League\Fractal\Pagination\IlluminatePaginatorAdapter as BaseAdapter;

class IlluminatePaginatorAdapter extends BaseAdapter
{
    /**
     * Create a new illuminate pagination adapter.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }
}
