<?php

namespace App\Http\Requests\Extract;

use App\Extract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\HttpStatusCodeUtils;

class Update extends FormRequest
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
        $extractId = $this->route('extract');
        $extract = Extract::find($extractId);

        $this->merge([
            "extract" => $extract
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
            'name'           => 'extract name',
            'value'          => 'value',
            'account_id'     => 'account identity',
            'recipient_id'   => 'recipient identity',
            'transaction_id' => 'transaction identity',
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
            "extract"        => ["required", "json"],
            'name'           => ['required', 'string'],
            'value'          => ['required', 'number'],
            'account_id'     => ['required', 'integer'],
            'recipient_id'   => ['required', 'integer'],
            'transaction_id' => ['required', 'integer'],
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

                $this->body = $this->validated();
                $this->inputs = [];

                foreach ($this->body as $key => $value) $this->inputs[$key] = $value;

                $this->merge([
                    'inputs' => $this->inputs,
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
