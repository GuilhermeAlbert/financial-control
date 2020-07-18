<?php

namespace App\Rules;

use App\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckAccountBalance implements Rule
{
    private $currentBalance;
    private $accountId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($currentBalance, $accountId)
    {
        $this->currentBalance = $currentBalance;
        $this->accountId = $accountId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $account = Account::find($this->accountId);

        if ($account->balance >= $this->currentBalance) return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This account does not have sufficient funds.';
    }
}
