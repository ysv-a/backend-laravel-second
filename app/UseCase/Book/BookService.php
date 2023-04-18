<?php

namespace App\UseCase\Book;

use DB;
use App\Dto\BookDto;
use App\Models\Book;
use App\Mail\NewBook;
use App\Models\Author;
use App\Services\FileUploader;
use App\Events\BookUpdatePrice;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;
use App\Services\Dispatchering\MultiDispatcher;

class BookService
{
    public function __construct(
        private readonly FileUploader $uploader,
        private readonly ConnectionInterface $connection,
        private readonly MultiDispatcher $dispatcher,
    ) {
    }

    public function create(BookDto $dto, string $fileUrl = null)
    {
        $this->isbnIsUnique($dto->isbn);

        $book = new Book;

        DB::transaction(function () use ($book, $dto, $fileUrl) {
            $book->user_id = $dto->user_id;
            $book->isbn = $dto->isbn;
            $book->title = $dto->title;
            $book->price = $dto->price->cent;
            $book->page = $dto->page;
            $book->year = $dto->year;
            $book->excerpt = $dto->excerpt;

            if ($fileUrl) {
                $book->image = $fileUrl;
            }

            $book->save();

            $ids = [];
            foreach ($dto->authors as $authorInput) {
                $author = Author::firstOrCreate([
                    'email' => $authorInput->email
                ], [
                    'first_name' => $authorInput->first_name,
                    'last_name' => $authorInput->last_name,
                    'patronymic' => $authorInput->patronymic,
                ]);

                $ids[] = $author->id;
            }
            $ids = [...$ids, ...$dto->authors_ids];

            $book->authors()->sync($ids);
        });

        // $this->connection->transaction(function () use ($book, $dto, $fileUrl) { });
        // Mail::send(new NewBook($book));

        return $book->refresh();
    }

    public function update($id, BookDto $dto, string $fileUrl = null)
    {

        $this->isbnIsUnique($dto->isbn, $id);

        $book = Book::findOrFail($id);

        $oldImage = $book->image;
        $old_price = $book->price;

        DB::transaction(function () use ($book, $dto, $fileUrl) {
            $book->isbn = $dto->isbn;
            $book->title = $dto->title;
            $book->price = $dto->price->cent;
            $book->page = $dto->page;
            $book->year = $dto->year;
            $book->excerpt = $dto->excerpt;
            if ($fileUrl) {
                $book->image = $fileUrl;
            }
            $book->save();

            if (count($dto->authors_ids)) {
                $book->authors()->sync($dto->authors_ids);
            }
        });

        if ($fileUrl && $oldImage) {
            $this->uploader->remove($oldImage);
        }

        $book->changePrice($dto->price->cent);

        $this->dispatcher->multiDispatch($book->releaseEvents());
        // if($dto->price->cent < $old_price->cent) {
        //     $this->dispatcher->dispatch(
        //         new BookUpdatePrice($book->id)
        //     );
        // }

        return $book->refresh();
    }



    public function publish($id)
    {
        $book = Book::findOrFail($id);

        $book->allowedPublish();

        $book->is_published = true;
        $book->save();

        return $book->refresh();
    }

    public function createOrUpdate(BookDto $bookDto)
    {
        $book = Book::where('isbn', $bookDto->isbn)->first();

        if ($book) {
            return $this->update($book->id, $bookDto);
        }
        return $this->create($bookDto);
    }

    private function isbnIsUnique(string $isbn, $exceptId = null): void
    {
        if ($exceptId) {
            $existBook = Book::where('isbn', $isbn)->where('id', '<>', $exceptId)->count();
        } else {
            $existBook = Book::where('isbn', $isbn)->count();
        }

        if ($existBook) {
            throw new BusinessException("Book with this isbn already exists " . $isbn);
        }
    }
}
