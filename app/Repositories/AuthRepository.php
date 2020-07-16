<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AuthInterface;
use App\User;

class AuthRepository extends BaseRepository implements AuthInterface
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
