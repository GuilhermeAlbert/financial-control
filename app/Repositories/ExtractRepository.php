<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ExtractInterface;
use App\Repositories\BaseRepository;
use App\Extract;

class ExtractRepository extends BaseRepository implements ExtractInterface
{
    // Protected variable context
    protected $model;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Extract $model)
    {
        $this->model = $model;
    }
}
