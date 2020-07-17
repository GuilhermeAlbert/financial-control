<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PersonInterface;
use App\Repositories\BaseRepository;
use App\Person;

class PersonRepository extends BaseRepository implements PersonInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Person $model)
    {
        $this->model = $model;
    }
}
