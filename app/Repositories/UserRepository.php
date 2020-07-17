<?php

namespace App\Repositories;


use App\Interfaces\Repositories\UserInterface;
use App\Repositories\BaseRepository;
use App\User;

class UserRepository extends BaseRepository implements UserInterface
{
    // Protected context items
    protected $model;

    /**
     * Constructor method
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
