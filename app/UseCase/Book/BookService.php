<?php

namespace App\UseCase\Book;

use App\Dto\BookDto;
use App\Models\Book;
use App\Mail\NewBook;
use App\Models\Author;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public function __construct(

    ) {
    }

    public function create(BookDto $dto, array $bookFileDto = [])
    {

        $this->isbnIsUnique($dto->isbn);

        $path = null;
        if (count($bookFileDto) && $bookFileDto['hasFile']) {
            $path = Storage::putFile('uploads', $bookFileDto['image']);
        }

        $book = new Book;
        $book->isbn = $dto->isbn;
        $book->title = $dto->title;
        $book->price = $dto->price;
        $book->page = $dto->page;
        $book->year = $dto->year;
        $book->excerpt = $dto->excerpt;
        $book->image = $path;
        $book->save();

        $ids = [];
        foreach ($dto->authors as $authorInput) {
            $author = new Author;
            $author->first_name = $authorInput->first_name;
            $author->last_name = $authorInput->last_name;
            $author->patronymic = $authorInput->patronymic;
            $author->email = $authorInput->email;
            $author->save();

            // $author = Author::firstOrCreate([
            //     'email' => $authorInput->email
            // ], [
            //     'first_name' => $authorInput->first_name,
            //     'last_name' => $authorInput->last_name,
            //     'patronymic' => $authorInput->patronymic,
            // ]);

            $ids[] = $author->id;
        }
        $ids = [...$ids, ...$dto->authors_ids];

        $book->authors()->sync($ids);

        Mail::send(new NewBook($book));

        return $book;
    }

    public function update($id, BookDto $dto, array $bookFileDto = [])
    {

        $book = Book::findOrFail($id);

        $path = null;
        if (count($bookFileDto) && $bookFileDto['hasFile']) {
            $path = Storage::putFile('uploads', $bookFileDto['image']);
        }

        if ($path && $book->image) {
            Storage::delete($book->image);
        }

        $book->isbn = $dto->isbn;
        $book->title = $dto->title;
        $book->price = $dto->price;
        $book->page = $dto->page;
        $book->year = $dto->year;
        $book->excerpt = $dto->excerpt;
        $book->image = $path;
        $book->save();

        if(count($dto->authors_ids)){
            $book->authors()->sync($dto->authors_ids);
        }


        return $book->refresh();
    }

    public function publish($id)
    {
        $book = Book::findOrFail($id);
        $book->is_published = true;
        $book->save();

        return $book->refresh();
    }

    public function createOrUpdate(BookDto $bookDto)
    {
        $book = Book::where('isbn', $bookDto->isbn)->first();

        if($book){
            return $this->update($book->id, $bookDto);
        }
        return $this->create($bookDto);
    }

    private function isbnIsUnique(string $isbn, $exceptId = null): void
    {
        if($exceptId){
            $existBook = Book::where('isbn', $isbn)->where('id', '<>', $exceptId)->count();
        }else{
            $existBook = Book::where('isbn', $isbn)->count();
        }

        if($existBook){
            throw new BusinessException("Book with this isbn already exists " . $isbn);
        }
    }

}
