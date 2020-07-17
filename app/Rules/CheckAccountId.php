<?php

namespace App\Rules;

use App\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckAccountId implements Rule
{
    private $modelId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($modelId)
    {
        $this->modelId = $modelId;
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
        $model = Account::find($this->modelId);

        if ($model) return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Account was not found.';
    }
}
