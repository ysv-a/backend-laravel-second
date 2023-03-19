<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'isbn' => 'required|unique:books,isbn',
            'title' => 'required|max:255',
            'price' => 'required|integer',
            'page' => 'required|integer',
            'year' => 'required|year',
            'authors_ids' => 'required|array',
            'file' => 'file|image',
        ];
    }
}
