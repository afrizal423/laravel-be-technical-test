<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // ubah ini hari senin
        // untuk user level admin maupun reader
        // selain dari itu tidak bisa mengakses
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
            'comment' => 'required|max:255|min:1',
            'user_id' =>'required|exists:users,id',
            'news_id' => 'required|exists:news,id'
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
            'comment.required' => 'komentar tidak boleh kosong',
            'comment.min' => 'komentar tidak boleh kurang dari 1 karakter',
            'comment.max' => 'komentar tidak boleh lebih dari 255 karakter',
            'user_id.required' => 'identitas user tidak boleh kosong',
            'news_id.required' => 'identitas berita tidak boleh kosong',
            'user_id.exists' => 'identitas user tidak ditemukan',
            'news_id.exists' => 'identitas berita tidak ditemukan',
        ];
    }
}
