<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionRepository;
use App\Http\Requests\Transaction\{
    Index,
    Show,
    Store,
    Update,
    Destroy,
    Restore
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;

class TransactionController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param TransactionRepository $model
     */
    public function __construct(TransactionRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all transactions
     * @api {GET} /api/transactions
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
     * Returns a specific transaction
     * @api {GET} /api/transactions/{transaction}
     * @param Show $request
     * @return Resource json
     */
    public function show(Show $request)
    {
        try {

            $object = $request->transaction;

            return new DefaultResource($object);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Create a new transaction
     * @api {POST} /api/transactions
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
     * Update a specific transaction
     * @api {GET} /api/transactions/{transaction}
     * @param Update $request
     * @return Resource json
     */
    public function update(Update $request)
    {
        try {

            $object = $this->model->update($request->inputs, $request->transaction);

            return new DefaultResource($object);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Delete a specific transaction
     * @api {GET} /api/transactions/{transaction}
     * @param Destroy $request
     * @return Resource json
     */
    public function destroy(Destroy $request)
    {
        try {

            $this->model->delete($request->transaction);

            return (new DefaultResource([]))->response()->setStatusCode(HttpStatusCodeUtils::NO_CONTENT);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Restore a specific transaction
     * @api {GET} /api/transactions/restore
     * @param Destroy $request
     * @return Resource json
     */
    public function restore(Restore $request)
    {
        try {

            $data = $this->model->restore($request->transaction);

            return (new DefaultResource($data))->response()->setStatusCode(HttpStatusCodeUtils::OK);
        } catch (\Exception $error) {
            throw $error;
        }
    }
}
