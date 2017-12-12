<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\UserEvents\UserCreatedEvent;
use App\Repositories\Contracts\UserRepository as UserRepositoryContract;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    /**
     * @inheritdoc
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /*
     * @inheritdoc
     */
    public function save(array $data)
    {
        // update password
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = parent::save($data);

        return $user;
    }
}
