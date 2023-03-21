<?php

namespace App\Dto;

use App\ValueObjects\Name;

class AuthorDto
{
    public function __construct(
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
