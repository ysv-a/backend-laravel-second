<?php

namespace App\Http\Requests;

use App\Dto\BookDto;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'isbn' => ['required', Rule::unique('books', 'isbn')->ignore($this->book)],
            'title' => 'required|max:255',
            'price' => 'required|integer',
            'page' => 'required|integer',
            'year' => 'required|year',
            'authors_ids' => 'required|array',
            'file' => 'file|image',
        ];
    }

    public function getDto(): BookDto
    {

        return new BookDto(
            isbn: $this->input('isbn'),
            title: $this->input('title'),
            price: $this->input('price'),
            page: $this->input('page'),
            year: $this->input('year'),
            authors_ids: $this->input('authors_ids'),
            excerpt: $this->input('excerpt') ?? '',
        );
    }

    public function bookFileDto(): array
    {

        return [
            'hasFile' => $this->hasFile('image'),
            'image' => $this->image
        ];
    }

}
