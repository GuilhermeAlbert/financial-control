<?php

namespace App\Rules;

use App\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckPersonAccountExistence implements Rule
{
    private $personId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($personId)
    {
        $this->personId = $personId;
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
        $account = Account::where('person_id', $this->personId)->first();

        if (!$account) return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This person already has an account.';
    }
}
