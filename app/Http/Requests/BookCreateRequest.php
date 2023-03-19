<?php

namespace App\Http\Requests;

use App\Dto\BookDto;
use App\Dto\AuthorDto;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            // 'isbn' => 'required|unique:books,isbn',
            'isbn' => 'required',
            'title' => 'required|max:255',
            'price' => 'required|integer',
            'page' => 'required|integer',
            'year' => 'required|integer',
            'authors_ids' => 'required|array',
            'file' => 'file|image',
        ];
    }

    public function getDto(): BookDto
    {

        $authors = [];
        foreach ($this->input('authors') as $authorInput) {
            if(empty($authorInput['first_name'])){
                continue;
            }

            $authorDto = new AuthorDto(
                first_name: $authorInput['first_name'],
                last_name: $authorInput['last_name'],
                patronymic: $authorInput['patronymic'],
                email: $authorInput['email'],
                biography: null,
            );


            $authors[] = $authorDto;
        }

        return new BookDto(
            isbn: $this->input('isbn'),
            title: $this->input('title'),
            price: $this->input('price'),
            page: $this->input('page'),
            year: $this->input('year'),
            authors: $authors,
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
