<?php

namespace App\Console\Commands;

use App\Dto\BookDto;
use App\Dto\AuthorDto;
use Illuminate\Console\Command;
use App\UseCase\Book\BookService;

class CsvBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:csv-book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookService $service): void
    {
        $authors = [
            ['first_name' => 'From CSV1', 'last_name' => 'From CSV1', 'patronymic' => 'From CSV1', 'email' => 'from_CSV1@gm.com'],
            ['first_name' => 'From CSV2', 'last_name' => 'From CSV2', 'patronymic' => 'From CSV2', 'email' => 'from_CSV2@gm.com'],
        ];

        $books = [
            ['isbn' => '1345345345', 'title' => 'Enduring Love Enduring Love', 'price' => 100, 'page'=> 500, 'year' => 2000, 'authors' => $authors],
            ['isbn' => '99945345', 'title' => 'The Fox The Fox', 'price' => 150, 'page'=> 350, 'year' => 2000,  'authors' => $authors],
            ['isbn' => '75755345353', 'title' => 'Doctor Faustus Doctor Faustus', 'price' => 200, 'page'=> 250, 'year' => 2000,  'authors' => $authors],
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

           try {
               $dto = new BookDto(
                   isbn: $book['isbn'],
                   title: $book['title'],
                   price: $book['price'],
                   page: $book['page'],
                   year: $book['year'],
                   authors: $authors,
                   authors_ids: [],
               );
               $service->create($dto);

               $this->info($book['title']);
           } catch (\Throwable $th) {
                $this->error($th->getMessage());
           }
        }
    }
}
