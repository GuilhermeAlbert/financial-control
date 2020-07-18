<?php

namespace App\Http\Requests\Account;

use App\Account;
use App\Rules\CheckAccountBalance;
use App\Rules\CheckTransactionId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\HttpStatusCodeUtils;
use App\Utils\TransactionUtils;

class Debit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $sourceAccount = Account::find($this->source_account_id);
        $transactionId = TransactionUtils::DEBIT;

        $this->merge([
            'source_account' => $sourceAccount,
            'transaction_id' => $transactionId,
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                    => 'transaction name',
            'previous_balance'        => 'previous account balance',
            'current_balance'         => 'current account balance',
            'source_account_id'       => 'source account identity',
            'destination_account_id'  => 'destination account identity',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                   => ["required", "string"],
            'previous_balance'       => ["nullable", "numeric"],
            'current_balance'        => ["required", "numeric"],
            'source_account_id'      => ["required", "integer", new CheckAccountBalance($this->current_balance, $this->source_account_id)],
            'destination_account_id' => ["nullable", "integer"],
            'transaction_id'         => ["required", "integer", new CheckTransactionId($this->transaction_id)],
            'source_account'         => ["required", "json"],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$validator->errors()->all()) {
                $this->merge([
                    'name'                   => $this->name,
                    'previous_balance'       => $this->previous_balance,
                    'current_balance'        => $this->current_balance,
                    'transaction_id'         => $this->transaction_id,
                    'source_account'         => $this->source_account,
                    'previous_balance'       => $this->source_account->balance,
                ]);
            }
        });
    }

    /**
     * Verify if has erros and print it
     *
     * @return Json
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors()->all(), HttpStatusCodeUtils::BAD_REQUEST)
        );
    }
}
