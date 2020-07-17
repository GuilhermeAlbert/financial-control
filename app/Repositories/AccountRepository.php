<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AccountInterface;
use App\Repositories\BaseRepository;
use App\Account;

class AccountRepository extends BaseRepository implements AccountInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Account $model)
    {
        $this->model = $model;
    }
}
