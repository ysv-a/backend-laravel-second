<?php

namespace App\JsonApi\V1\Books;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BookRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $book = $this->model();
        $unique = Rule::unique('books', 'isbn');

        if ($book) {
            $unique->ignoreModel($book);
        }


        return [
            'isbn' => ['required', 'string', $unique],
            'title' => ['required', 'string'],
            'price' => ['required', 'decimal:0,2'],
            'page' => ['required','integer'],
            'year' => ['required','integer'],
            'excerpt' => ['nullable'],
            'authors' => JsonApiRule::toMany(),
        ];
    }
}
