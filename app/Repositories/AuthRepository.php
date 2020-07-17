<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AuthInterface;
use App\Person;
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

    /**
     * Attach person with user 
     * @param User $user
     * @param String $document
     * @return void
     */
    public function attachPersonWithUser($user, $document)
    {
        $person = new Person();
        $person->document = $document;
        $person->document = $document;
        $person->user_id  = $user->id;
        $person->save();
    }
}
