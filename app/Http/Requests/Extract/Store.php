<?php

namespace App\Http\Requests\Extract;

use App\Rules\CheckAccountId;
use App\Rules\CheckTransactionId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\HttpStatusCodeUtils;

class Store extends FormRequest
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
        $this->merge([
            // 
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
            'name'                   => 'transaction name',
            'previous_balance'       => 'previous account balance',
            'current_balance'        => 'current account balance',
            'source_account_id'      => 'source account identity',
            'destination_account_id' => 'destinationaccount identity',
            'transaction_id'         => 'transaction identity',
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
            'previous_balance'       => ["required", "numeric"],
            'current_balance'        => ["required", "numeric"],
            'source_account_id'      => ["required", "integer", new CheckAccountId($this->source_account_id)],
            'destination_account_id' => ["required", "integer", new CheckAccountId($this->destination_account_id)],
            'transaction_id'         => ["required", "integer", new CheckTransactionId($this->transaction_id)],
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
                    'inputs' => [
                        'extract'                => $this->extract,
                        'name'                   => $this->name,
                        'previous_balance'       => $this->previous_balance,
                        'current_balance'        => $this->current_balance,
                        'source_account_id'      => $this->source_account_id,
                        'destination_account_id' => $this->destination_account_id,
                        'transaction_id'         => $this->transaction_id,
                    ],
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
