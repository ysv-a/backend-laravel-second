<?php

namespace App\UseCase\Book;

use App\Dto\BookDto;
use App\Models\Book;
use App\Mail\NewBook;
use App\Events\BookCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

class BookServiceFacade
{
    public function create(BookDto $dto): Book
    {
        $book = new Book;

        DB::transaction(function () use ($book, $dto) {
            $book->user_id = $dto->user_id;
            $book->isbn = $dto->isbn;
            $book->title = $dto->title;
            $book->price = $dto->price->cent;
            $book->page = $dto->page;
            $book->year = $dto->year;
            $book->excerpt = $dto->excerpt;

            $book->save();


            $book->authors()->sync($dto->authors_ids);
        });

        Event::dispatch(new BookCreated($book->id));

        Mail::send(new NewBook($book));

        return $book;
    }
}
