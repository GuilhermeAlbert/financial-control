<?php

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use App\Http\Requests\Address\{
    Index,
    Show,
    Store,
    Update,
    Destroy,
    Restore
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;

class AddressController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param AddressRepository $model
     */
    public function __construct(AddressRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all addresses
     * @api {GET} /api/addresses
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
     * Returns a specific address
     * @api {GET} /api/addresses/{address}
     * @param Show $request
     * @return Resource json
     */
    public function show(Show $request)
    {
        try {

            $object = $request->address;

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Create a new address
     * @api {POST} /api/addresses
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
     * Update a specific address
     * @api {GET} /api/addresses/{address}
     * @param Update $request
     * @return Resource json
     */
    public function update(Update $request)
    {
        try {

            $object = $this->model->update($request->inputs, $request->address);

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Delete a specific address
     * @api {GET} /api/addresses/{address}
     * @param Destroy $request
     * @return Resource json
     */
    public function destroy(Destroy $request)
    {
        try {

            $this->model->delete($request->address);

            return (new DefaultResource([]))->response()->setStatusCode(HttpStatusCodeUtils::NO_CONTENT);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Restore a specific address
     * @api {GET} /api/addresses/restore
     * @param Destroy $request
     * @return Resource json
     */
    public function restore(Restore $request)
    {
        try {

            $data = $this->model->restore($request->address);

            return (new DefaultResource($data))->response()->setStatusCode(HttpStatusCodeUtils::OK);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }
}
