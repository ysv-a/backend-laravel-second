<?php

namespace App\Dto;

use App\Cast\CastToName;
use App\ValueObjects\Name;
use OpenApi\Attributes as OA;
use EventSauce\ObjectHydrator\MapFrom;

class AuthorDto
{
    #[OA\Schema(
        schema: 'AuthorDto',
        properties: [
            new OA\Property(
                property: "email",
                type: "string"
            ),
            new OA\Property(
                property: "biography",
                type: "string"
            ),
            new OA\Property(
                property: "name",
                type: "object",
                properties: [
                    new OA\Property(
                        property: "first_name",
                        type: "string",
                    ),
                    new OA\Property(
                        property: "last_name",
                        type: "string",
                    ),
                    new OA\Property(
                        property: "patronymic",
                        type: "string",
                    ),
                    new OA\Property(
                        property: "full_name",
                        type: "string",
                    )
                ]
            ),
        ],
        type: 'object',
    )]

    public function __construct(
        #[CastToName]
        #[MapFrom(['first_name' => 'first_name', 'last_name', 'patronymic'])]
        public readonly Name $name,
        public readonly string $email,
        public readonly ?string $biography,
    ) {
    }
    // public function __construct(
    //     public readonly string $first_name,
    //     public readonly string $last_name,
    //     public readonly ?string $patronymic,
    //     public readonly string $email,
    //     public readonly ?string $biography,
    // ) {
    // }
}
