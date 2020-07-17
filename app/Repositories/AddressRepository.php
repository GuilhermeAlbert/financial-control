<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AddressInterface;
use App\Repositories\BaseRepository;
use App\Address;

class AddressRepository extends BaseRepository implements AddressInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Address $model)
    {
        $this->model = $model;
    }
}
