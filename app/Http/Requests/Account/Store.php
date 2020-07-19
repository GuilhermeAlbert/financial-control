<?php

namespace App\Http\Requests\Account;

use App\Rules\CheckPersonAccountExistence;
use App\Rules\CheckPersonId;
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
            "balance" => 0
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
            'name'       => 'account name',
            'balance'    => 'account balance',
            'person_id'  => 'person identity',
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
            'name'       => ['required', 'string'],
            'balance'    => ['required', 'numeric'],
            'person_id'  => ['required', 'integer', new CheckPersonId($this->person_id), new CheckPersonAccountExistence($this->person_id)],
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
                        'name'       => $this->name,
                        'balance'    => $this->balance,
                        'person_id'  => $this->person_id,
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
