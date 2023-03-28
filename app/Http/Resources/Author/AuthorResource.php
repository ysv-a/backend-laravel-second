<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class AuthorResource extends JsonResource
{
    #[OA\Schema(
        schema: 'AuthorResource',
        properties: [
            new OA\Property(
                property: 'id',
                type: "integer",
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: 'first_name',
                type: "string",
                example: 1
            ),
            new OA\Property(
                property: 'last_name',
                type: "string",
                example: 1
            ),
            new OA\Property(
                property: 'patronymic',
                type: "string",
                example: 1
            ),
            new OA\Property(
                property: 'email',
                type: "string",
                example: 1
            ),
            new OA\Property(
                property: 'biography',
                type: "string",
                example: 1
            ),
        ],
        type: 'object',
    )]

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'patronymic'        => $this->patronymic,
            'email'             => $this->email,
            'biography'         => $this->biography,
        ];
    }
}
