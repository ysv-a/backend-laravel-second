<?php

namespace App\Dto;

class BookDto
{
    /**
     * @param  AuthorDto[]  $authors
     */

    public function __construct(
        public readonly string $isbn,
        public readonly string $title,
        public readonly int $price,
        public readonly int $page,
        public readonly int $year,
        public readonly array $authors_ids,
        public readonly array $authors = [],
        public readonly string $excerpt = '',
    ) {
    }
}
