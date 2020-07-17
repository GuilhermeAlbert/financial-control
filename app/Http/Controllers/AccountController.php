<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Http\Requests\Account\{
    Index,
    Show,
    Store,
    Update,
    Destroy,
    Restore
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;

class AccountController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param AccountRepository $model
     */
    public function __construct(AccountRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all accounts
     * @api {GET} /api/accounts
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
     * Returns a specific account
     * @api {GET} /api/accounts/{account}
     * @param Show $request
     * @return Resource json
     */
    public function show(Show $request)
    {
        try {

            $object = $request->account;

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Create a new account
     * @api {POST} /api/accounts
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
     * Update a specific account
     * @api {GET} /api/accounts/{account}
     * @param Update $request
     * @return Resource json
     */
    public function update(Update $request)
    {
        try {

            $object = $this->model->update($request->inputs, $request->account);

            return new DefaultResource($object);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Delete a specific account
     * @api {GET} /api/accounts/{account}
     * @param Destroy $request
     * @return Resource json
     */
    public function destroy(Destroy $request)
    {
        try {

            $this->model->delete($request->account);

            return (new DefaultResource([]))->response()->setStatusCode(HttpStatusCodeUtils::NO_CONTENT);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }

    /**
     * Restore a specific account
     * @api {GET} /api/accounts/restore
     * @param Destroy $request
     * @return Resource json
     */
    public function restore(Restore $request)
    {
        try {

            $data = $this->model->restore($request->account);

            return (new DefaultResource($data))->response()->setStatusCode(HttpStatusCodeUtils::OK);
        } catch (\Exception $error) {
            return new DefaultErrorResource(['errors' => $error->getMessage()]);
        }
    }
}
