<?php

namespace App\Http\Requests\Address;

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
            'street'     => 'address street',
            'number'     => 'address number',
            'city'       => 'address city',
            'state'      => 'address state',
            'zip_code'   => 'address zip code',
            'country'    => 'address country',
            'complement' => 'address complement',
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
            'street'     => ['required', 'string'],
            'number'     => ['required', 'string'],
            'city'       => ['required', 'string'],
            'state'      => ['required', 'string'],
            'zip_code'   => ['nullable', 'string'],
            'country'    => ['required', 'string'],
            'complement' => ['nullable', 'string'],
            'person_id'  => ['required', 'integer'],
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
                        'street'     => $this->street,
                        'number'     => $this->number,
                        'city'       => $this->city,
                        'state'      => $this->state,
                        'zip_code'   => $this->zip_code,
                        'country'    => $this->country,
                        'complement' => $this->complement,
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
