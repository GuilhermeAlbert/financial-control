<?php

namespace App\Services;

use App\Interfaces\Services\AccountInterface;

class AccountService implements AccountInterface
{
    // Protected variable context
    protected $service;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct()
    {
        // 
    }

    /**
     * Make a debit operation from account
     * @param App/Account $account
     * @param Decimal $balance
     * @return void
     */
    public function debit($account, $balance)
    {
        $account->balance -= $balance;
        $account->save();
    }

    /**
     * Make a credit operation for account
     * @param App/Account $account
     * @param Decimal $balance
     * @return void
     */
    public function credit($account, $balance)
    {
        $account->balance += $balance;
        $account->save();
    }
}
