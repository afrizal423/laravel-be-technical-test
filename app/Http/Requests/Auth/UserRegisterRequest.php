<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'email' => 'email|required|min:3|max:100|unique:users,email',
            'password' => 'required|min:4|max:100'
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
            'name.required' => 'nama tidak boleh kosong',
            'name.min' => 'nama harus memiliki minimal 3 huruf',
            'name.max' => 'nama tidak boleh lebih dari 100 huruf',
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email haruslah berformat email',
            'email.min' => 'email harus memiliki minimal 3 huruf',
            'email.max' => 'email tidak boleh lebih dari 100 huruf',
            'email.unique' => 'email sudah dipakai, silahkan ganti',
            'password.required' => 'password tidak boleh kosong',
            'password.min' => 'password harus memiliki minimal 4 huruf',
            'password.max' => 'password tidak boleh lebih dari 100 huruf',
        ];
    }
}
