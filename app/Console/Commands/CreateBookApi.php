<?php

namespace App\Console\Commands;

use App\Dto\BookDto;
use App\Dto\AuthorDto;
use Illuminate\Console\Command;
use App\UseCase\Book\BookService;

class CreateBookApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-book-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookService $bookService): void
    {
        $authors = [
            ['first_name' => 'From CLI', 'last_name' => 'From CLI', 'patronymic' => 'From CLI', 'email' => 'from_cli@gm.com'],
            ['first_name' => 'From CLI2', 'last_name' => 'From CLI2', 'patronymic' => 'From CLI2', 'email' => 'from_cli2@gm.com'],
        ];
        $authors2 = [
            ['first_name' => 'From CLI3', 'last_name' => 'From CLI3', 'patronymic' => 'From CLI3', 'email' => 'from_cli3@gm.com'],
        ];

        $books = [
            ['isbn' => '88888880', 'title' => 'Create from CLI', 'price' => 50000, 'page' => 200, 'year' => 2000, 'excerpt' => '', 'image' => '', 'authors' => $authors],
            ['isbn' => '90909090', 'title' => 'Create from CLI 2', 'price' => 52, 'page' => 202, 'year' => 2002, 'excerpt' => '', 'image' => '', 'authors' => $authors2],
        ];

        foreach ($books as $book) {
            $authors = [];
            foreach ($book['authors'] as $author) {
                $authorDto = new AuthorDto(
                    first_name: $author['first_name'],
                    last_name: $author['last_name'],
                    patronymic: $author['patronymic'],
                    email: $author['email'],
                    biography: null,
                );
                $authors[] = $authorDto;
            }
            $bookDto = new BookDto(
                isbn: $book['isbn'],
                title: $book['title'],
                price: $book['price'],
                page: $book['page'],
                year: $book['year'],
                authors: $authors,
                authors_ids: [],
            );

            $bookService->createOrUpdate($bookDto);

            $this->info($book['isbn']);
        }
    }
}
