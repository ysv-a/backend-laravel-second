<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Events\BookUpdatePrice;
use App\Exceptions\BusinessException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;


    public function test_event_price_change_reduction()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id,
            'price' => 1000
        ]);

        $book->changePrice(200);

        $this->assertEventsHas(BookUpdatePrice::class, $book->releaseEvents());
    }


    public function test_no_event_price_change()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id,
            'price' => 1000
        ]);
        $book->changePrice(1200);

        $this->assertEventsNoHas(BookUpdatePrice::class, $book->releaseEvents());
    }

    public function test_cannot_publish_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id,
            'price' =>  10
        ]);

        $this->expectException(BusinessException::class);

        $book->allowedPublish();

    }

}
