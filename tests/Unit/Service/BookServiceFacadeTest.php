<?php

namespace Tests\Unit\Service;

use Tests\TestCase;
use App\Dto\BookDto;
use App\Models\Book;
use App\Mail\NewBook;
use App\Models\Author;
use App\Events\BookCreated;
use App\ValueObjects\PriceReverse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\UseCase\Book\BookServiceFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookServiceFacadeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function test_create_by_books_service()
    {
        Event::fake();
        Mail::fake();

        $authors_id = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $bookService = new BookServiceFacade();
        $dto = new BookDto(
            user_id: 1,
            isbn: '234234234',
            title: 'New Book Title',
            price: new PriceReverse(500),
            page: 55,
            year: 2020,
            authors_ids: $authors_id
        );
        $book = $bookService->create($dto, $authors_id);

        Event::assertDispatched(BookCreated::class);
        Mail::assertSent(function (NewBook $mail) use ($book) {
            return $mail->book === $book;
        });

        $this->assertDatabaseHas(Book::class, [
             'isbn' => '234234234',
         ]);
    }
}
