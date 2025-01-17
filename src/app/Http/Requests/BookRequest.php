<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow this request
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:256',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'display' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The ":attribute" field is required.',
            'min' => 'The ":attribute" field must be at least :min characters.',
            'max' => 'The ":attribute" field may not be greater than :max characters.',
            'numeric' => 'The ":attribute" field must be a valid number.',
            'image' => 'The ":attribute" field must be a valid image (jpeg, png, webp).',
            'exists' => 'The selected ":attribute" is invalid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Book Name',
            'author_id' => 'Author',
            'genre_id' => 'Genre',
            'description' => 'Description',
            'price' => 'Price',
            'year' => 'Year',
            'image' => 'Book Image',
            'display' => 'Display',
        ];
    }
}
