<?php

namespace App\Http\Requests;

use App\Dto\BookDto;
use App\Dto\AuthorDto;
use App\ValueObjects\Name;
use Illuminate\Validation\Rule;
use App\ValueObjects\PriceReverse;
use Illuminate\Foundation\Http\FormRequest;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use Illuminate\Support\Facades\Auth;

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
            'price' => 'required|decimal:0,2',
            'page' => 'required|integer',
            'year' => 'required|integer',
            'authors_ids' => 'required|array',
            'image' => 'file|image',
            'authors.*.last_name' => 'required_with:authors.*.first_name',
            'authors.*.email' => 'nullable|email|required_with:authors.*.first_name',
        ];
    }

    public function getDto(): BookDto
    {

        $mapper = new ObjectMapperUsingReflection();
        $command = $mapper->hydrateObject(
            BookDto::class,
            [...$this->all(), 'user_id' => Auth::user()->id],
        );

        return $command;

        $authors = [];
        if ($this->input('authors')) {
            foreach ($this->input('authors') as $authorInput) {
                if (empty($authorInput['first_name'])) {
                    continue;
                }

                $authorDto = new AuthorDto(
                    name: new Name(
                        $authorInput['first_name'],
                        $authorInput['last_name'],
                        $authorInput['patronymic']
                    ),
                    email: $authorInput['email'],
                    biography: null,
                );


                $authors[] = $authorDto;
            }
        }


        return new BookDto(
            isbn: $this->input('isbn'),
            title: $this->input('title'),
            price: new PriceReverse($this->input('price')),
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
