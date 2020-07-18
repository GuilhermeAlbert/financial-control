<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AccountInterface;
use App\Repositories\BaseRepository;
use App\{Account};
use App\Services\AccountService;

class AccountRepository extends BaseRepository implements AccountInterface
{
    // Protected variable context
    protected $model;
    protected $extract;
    protected $service;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Account $model, ExtractRepository $extract, AccountService $service)
    {
        $this->model = $model;
        $this->extract = $extract;
        $this->service = $service;
    }

    /**
     * Make a debit operation
     * @return Collection
     */
    public function debit(
        $name,
        $previousBalance,
        $currentBalance,
        $transactionId,
        $sourceAccount
    ) {
        $this->service->debit($sourceAccount, $currentBalance);

        $inputs = [
            'name'                   => $name,
            'previous_balance'       => $previousBalance,
            'current_balance'        => $currentBalance,
            'transaction_id'         => $transactionId,
            'source_account_id'      => $sourceAccount->id,
        ];

        $this->extract->create($inputs);
    }

    /**
     * Make a credit operation
     * @return Collection
     */
    public function credit(
        $name,
        $previousBalance,
        $currentBalance,
        $transactionId,
        $destinationAccount
    ) {
        $this->service->credit($destinationAccount, $currentBalance);

        $inputs = [
            'name'                   => $name,
            'previous_balance'       => $previousBalance,
            'current_balance'        => $currentBalance,
            'transaction_id'         => $transactionId,
            'destination_account_id' => $destinationAccount->id,
        ];

        $this->extract->create($inputs);
    }

    /**
     * Make a transfer operation
     * @return Collection
     */
    public function transfer(
        $name,
        $previousBalance,
        $currentBalance,
        $transactionId,
        $sourceAccount,
        $destinationAccount
    ) {
        $this->service->debit($sourceAccount, $currentBalance);
        $this->service->credit($destinationAccount, $currentBalance);

        $inputs = [
            'name'                   => $name,
            'previous_balance'       => $previousBalance,
            'current_balance'        => $currentBalance,
            'transaction_id'         => $transactionId,
            'destination_account_id' => $destinationAccount->id,
            'source_account_id'      => $sourceAccount->id,
        ];

        $this->extract->create($inputs);
    }
}
