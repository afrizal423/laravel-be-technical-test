<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // free access
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'email|required',
            'password' => 'required'
        ];
    }

    /**
     * custom validation error
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }

    /**
     * Custom message error
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email haruslah berformat email',
            'password.required' => 'password tidak boleh kosong',
        ];
    }
}
