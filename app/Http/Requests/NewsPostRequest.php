<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // strict khusus admin
        if (auth()->user()->is_admin) {
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
        // jika update data
        // kenapa  _method? karena laravel tidak bisa memakai request method PUT
        // maka harus menambahkan ?_method=PUT 'https://example.com/api/v1/news/$id?_method=PUT'
        // referensi https://stackoverflow.com/a/61960048
        if ($this->method() == 'PUT' || $this->input('_method') == 'PUT') {
            return [
                'title' => 'required|max:255|min:5',
                'content' => 'required|min:5',
                'image_banner' => 'image|mimes:jpg,png,jpeg|max:2048',
            ];
        } else {
        // jika insert data
            return [
                'title' => 'required|max:255|min:5',
                'content' => 'required|min:5',
                'image_banner' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ];
        }


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
            'title.required' => 'judul tidak boleh kosong',
            'title.min' => 'judul tidak boleh kurang dari 5 karakter',
            'title.max' => 'judul tidak boleh lebih dari 255 karakter',
            'content.required' => 'isi konten tidak boleh kosong',
            'content.min' => 'isi konten tidak boleh kurang dari 5 karakter',
            'image_banner.required' => 'gambar banner tidak boleh kosong',
            'image_banner.image' => 'gambar banner harus berupa file gambar',
            'image_banner.mimes' => 'file gambar banner harus berformat: jpg, png, jpeg',
        ];
    }
}
