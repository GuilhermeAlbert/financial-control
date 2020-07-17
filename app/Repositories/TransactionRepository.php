<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TransactionInterface;
use App\Repositories\BaseRepository;
use App\Transaction;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }
}
