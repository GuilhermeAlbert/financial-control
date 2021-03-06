<?php

namespace App\Http\Controllers;

use App\Repositories\ExtractRepository;
use App\Http\Requests\Extract\{
    Index,
    Show,
    Store,
    Update,
    Destroy,
    Restore
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;

class ExtractController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param ExtractRepository $model
     */
    public function __construct(ExtractRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all extracts
     * @api {GET} /api/extracts
     * @param Index $request
     * @return Resource json
     */
    public function index(Index $request)
    {
        try {

            $object = $this->model->all();

            return new DefaultResource($object);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Returns a specific extract
     * @api {GET} /api/extracts/{extract}
     * @param Show $request
     * @return Resource json
     */
    public function show(Show $request)
    {
        try {

            $object = $request->extract;

            return new DefaultResource($object);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Create a new extract
     * @api {POST} /api/extracts
     * @param Store $request
     * @return Resource json
     */
    public function store(Store $request)
    {
        try {

            $object = $this->model->create($request->inputs);

            return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::CREATED);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Update a specific extract
     * @api {GET} /api/extracts/{extract}
     * @param Update $request
     * @return Resource json
     */
    public function update(Update $request)
    {
        try {

            $object = $this->model->update($request->inputs, $request->extract);

            return new DefaultResource($object);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Delete a specific extract
     * @api {GET} /api/extracts/{extract}
     * @param Destroy $request
     * @return Resource json
     */
    public function destroy(Destroy $request)
    {
        try {

            $this->model->delete($request->extract);

            return (new DefaultResource([]))->response()->setStatusCode(HttpStatusCodeUtils::NO_CONTENT);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Restore a specific extract
     * @api {GET} /api/extracts/restore
     * @param Destroy $request
     * @return Resource json
     */
    public function restore(Restore $request)
    {
        try {

            $data = $this->model->restore($request->extract);

            return (new DefaultResource($data))->response()->setStatusCode(HttpStatusCodeUtils::OK);
        } catch (\Exception $error) {
            throw $error;
        }
    }
}
