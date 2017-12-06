<?php

namespace App\Repositories\Decorators;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Events\UserEvents\UserCreatedEvent;
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
