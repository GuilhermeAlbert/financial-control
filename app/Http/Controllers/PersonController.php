<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Http\Requests\Person\{
    Index,
    Show,
    Store,
    Update,
    Destroy
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;

class PersonController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param PersonRepository $model
     */
    public function __construct(PersonRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all people
     * @api {GET} /api/people
     * @param Index $request
     * @return Resource json
     */
    public function index(Index $request)
    {
        try {

            $object = $this->model->all();

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Returns a specific person
     * @api {GET} /api/people/{person}
     * @param Show $request
     * @return Resource json
     */
    public function show(Show $request)
    {
        try {

            $object = $request->person;

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Create a new person
     * @api {POST} /api/people
     * @param Store $request
     * @return Resource json
     */
    public function store(Store $request)
    {
        try {

            $object = $this->model->create($request->inputs);

            return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::CREATED);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Update a specific person
     * @api {GET} /api/people/{person}
     * @param Update $request
     * @return Resource json
     */
    public function update(Update $request)
    {
        try {

            $object = $this->model->update($request->inputs, $request->person);

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Delete a specific person
     * @api {GET} /api/people/{person}
     * @param Destroy $request
     * @return Resource json
     */
    public function destroy(Destroy $request)
    {
        try {

            $this->model->delete($request->person);

            return (new DefaultResource([]))->response()->setStatusCode(HttpStatusCodeUtils::NO_CONTENT);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }
}
