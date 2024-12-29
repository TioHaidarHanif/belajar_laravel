<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'author' => ['required', 'string'],
            'year' => ['required', 'integer'],
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
public function messages()
{
    return [
        'title.required' => 'Judul buku harus diisi',
        'author.required' => 'Penulis buku harus diisi',
        'year.required' => 'Tahun terbit buku harus diisi',
        'year.integer' => 'Tahun terbit buku harus berupa angka',
    ];
}
}