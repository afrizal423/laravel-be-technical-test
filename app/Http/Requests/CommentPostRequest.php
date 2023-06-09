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
        // khusus admin dan member
        if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 0) {
            return true;
        } else {
            return false;
        }
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
            'news_id.required' => 'identitas berita tidak boleh kosong',
            'news_id.exists' => 'identitas berita tidak ditemukan',
        ];
    }
}
