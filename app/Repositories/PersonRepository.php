<?php

namespace App\Repositories;

use App\Interfaces\Repositories\StubInterface;
use App\Repositories\BaseRepository;
use App\Stub;

class PersonRepository extends BaseRepository implements StubInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Stub $model)
    {
        $this->model = $model;
    }
}