<?php

namespace App\Http\Resources\Book;

use OpenApi\Attributes as OA;
use App\Http\Resources\Author\AuthorCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    #[OA\Schema(
        schema: 'BookResource',
        properties: [
            new OA\Property(
                property: 'id',
                type: "integer",
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: "page",
                type: "integer",
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: "year",
                type: "integer",
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: "price",
                type: "object",
                properties: [
                    new OA\Property(
                        property: "cent",
                        type: "integer"
                    ),
                    new OA\Property(
                        property: "dollar",
                        type: "number",
                        format: "double",
                    ),
                    new OA\Property(
                        property: "formatted",
                        type: "string",
                    )
                ]
            ),

            new OA\Property(
                property: 'isbn',
                type: "string",
                example: 'isbn'
            ),
            new OA\Property(
                property: 'title',
                type: "string",
                example: 'title'
            ),
            new OA\Property(
                property: 'excerpt',
                type: "string",
                example: 'excerpt'
            ),
            new OA\Property(
                property: 'authors',
                type: "array",
                items: new OA\Items(
                    ref: "#/components/schemas/AuthorResource"
                )
            )
        ],
        type: 'object',
    )]


    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'isbn'          => $this->isbn,
            'title'         => $this->title,
            'price'         => $this->price,
            'page'          => $this->page,
            'year'          => $this->year,
            'excerpt'       => $this->excerpt,
            'authors'       => new AuthorCollection($this->authors)
        ];
    }
}
