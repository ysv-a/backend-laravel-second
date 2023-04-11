<?php

namespace App\Dto;

use App\Cast\CastToMoney;
use OpenApi\Attributes as OA;
use App\ValueObjects\PriceReverse;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class BookDto
{
    #[OA\Schema(
        schema: 'BookDto',
        required: ['isbn', 'title'],
        properties: [
            new OA\Property(
                property: "isbn",
                type: "string"
            ),
            new OA\Property(
                property: "title",
                type: "string"
            ),
            new OA\Property(
                property: "price",
                type: "number",
                format: "double"
            ),
            new OA\Property(
                property: "page",
                type: "integer",
                format: 'int64'
            ),
            new OA\Property(
                property: "year",
                type: "integer",
                format: 'int64'
            ),
            new OA\Property(
                property: "excerpt",
                type: "string",
            ),
            new OA\Property(
                property: "authors_ids",
                type: "array",
                items: new OA\Items(
                    type: "integer"
                )
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


    /**
     * @param  AuthorDto[]  $authors
     */

    public function __construct(
        public readonly int $user_id,
        public readonly string $isbn,
        public readonly string $title,
        #[CastToMoney]
        public readonly PriceReverse $price,
        #[CastToType('integer')]
        public readonly int $page,
        #[CastToType('integer')]
        public readonly int $year,
        public readonly array $authors_ids,
        #[CastListToType(AuthorDto::class)]
        public readonly array $authors = [],
        public readonly string $excerpt = '',
    ) {
    }
}
