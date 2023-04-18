<?php

namespace Tests\Unit\Service;

use Tests\TestCase;
use App\Dto\BookDto;
use App\Events\BookCreated;
use Tests\Fakes\FakeConnection;
use Illuminate\Mail\MailManager;
use App\ValueObjects\PriceReverse;
use Tests\Fakes\BookFakeRepository;
use App\UseCase\Book\BookServiceNoFacade;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Testing\Fakes\MailFake;
use Illuminate\Support\Testing\Fakes\EventFake;

class BookServiceNoFacadeTest extends TestCase
{
    /** @test */
    public function test_create_by_books_service_no_facade()
    {
        $eventFake = new EventFake($this->createMock(Dispatcher::class));

        $mailFake = new MailFake($this->createMock(MailManager::class));


        $bookService = new BookServiceNoFacade(
            $mailFake,
            $eventFake,
            new FakeConnection(),
            new BookFakeRepository(),
        );

        $dto = new BookDto(
            user_id: 1,
            isbn: '234234234',
            title: 'New Book Title',
            price: new PriceReverse(500),
            page: 55,
            year: 2020,
            authors_ids: [1,2,3]
        );
        $book = $bookService->create($dto, [1,2,3]);

        $eventFake->assertDispatched(BookCreated::class);

        $this->assertEquals(10, $book->id);

    }
}
