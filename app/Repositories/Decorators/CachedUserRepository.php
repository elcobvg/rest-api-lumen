<?php

namespace App\Repositories\Decorators;

use App\Repositories\Contracts\UserRepository as UserRepositoryContract;

class CachedUserRepository extends CachedRepository implements UserRepositoryContract
{
    /**
     * The type of the resource
     *
     * @var string
     */
    protected $resourceType = 'users';
}
