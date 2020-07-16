<?php

namespace App\Http\Requests\Contact;

use App\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\{HttpStatusCodeUtils, Strings};
use Illuminate\Support\Facades\Auth;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $contact = Contact::find($this->route('contact'));
        // return $contact && $this->user()->can('update', $contact);

        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Gets the contact from route
        $contactId = $this->route('contact');
        $contact = Contact::find($contactId);

        // Characters to be removed
        $characters = ["(", ")", "+", " ", "-"];

        // Remove some characters from phone
        if ($this->phone) $this->phone = Strings::removeCharacters($characters, $this->phone);

        $this->merge([
            'phone'   => $this->phone,
            'contact' => $contact,
            'user_id' => Auth::user()->id,
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
            'first_name' => 'first name',
            'email'      => 'email address',
            'phone'      => 'phone number',
            'user_id'    => 'user identification',
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
            "first_name" => ["required", "string", "max:255"],
            "email"      => ["required", "email", "string"],
            "phone"      => ["required", "string"],
            "contact"    => ["required", "json"],
            "user_id"    => ["required", "integer"]
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
            "contact.required" => ":attribute not found."
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
