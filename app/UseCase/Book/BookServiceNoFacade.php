<?php

namespace App\UseCase\Book;

use App\Dto\BookDto;
use App\Models\Book;
use App\Mail\NewBook;
use App\Services\Sms\Sms;
use App\Events\BookCreated;
use Illuminate\Contracts\Mail\Mailer;
use App\Services\Repository\BookRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;

class BookServiceNoFacade
{

    public function __construct(
        public Mailer $mailer,
        public Dispatcher $dispatcher,
        public ConnectionInterface $connection,
        public BookRepository $repository,
    ) {
    }

    public function create(BookDto $dto): Book
    {
        $book = new Book;

        $this->connection->transaction(function () use ($book, $dto) {
            $book->user_id = $dto->user_id;
            $book->isbn = $dto->isbn;
            $book->title = $dto->title;
            $book->price = $dto->price->cent;
            $book->page = $dto->page;
            $book->year = $dto->year;
            $book->excerpt = $dto->excerpt;
            $this->repository->save($book);
            $this->repository->sync($book, $dto->authors_ids);
        });

        $this->dispatcher->dispatch(
            new BookCreated($book->id)
        );
        $this->mailer->send(new NewBook($book));

        return $book;
    }
}
