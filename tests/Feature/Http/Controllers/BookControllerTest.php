<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Http\Controllers\BookController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->user = $user;
        $this->be($user);

    }

    public function test_index_shows_a_list_of_books()
    {

        Book::factory()->count(1)->create([
            'title' => 'new book title'
        ]);

        $this
            ->get(action([BookController::class, 'index']), [])
            ->assertSuccessful()
            ->assertSee('new book title');
    }



    public function test_store_book()
    {
        $book = Book::factory()->create();
        $authors = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $this
            ->post(action([BookController::class, 'store']), [
                'isbn' => '546546546546546546465',
                'title'  => $book->title,
                'price' => 200,
                'page'  => $book->page,
                'year'  => $book->year,
                'authors_ids' => $authors,
            ])
            ->assertSessionHas('success', 'The book has been successfully created')
            ->assertRedirect();


        $this
            ->get(action([BookController::class, 'index']), [])
            ->assertSuccessful()
            ->assertSee('546546546546546546465');


        //        $this->assertDatabaseHas(Book::class, [
        //            'isbn' => '546546546546546546465',
        //        ]);

    }



    public function test_update_book()
    {
        $book = Book::factory()->create([
            'isbn' => 'very old isbn'
        ]);
        $authors = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $this
            ->get(action([BookController::class, 'index']), [])
            ->assertSuccessful()
            ->assertSee('very old isbn');

        $this->put(
            action([BookController::class, 'update'], $book->id),
            [
                'isbn' => 'isbn - is - updated',
                'title'  => $book->title,
                'price' => 200,
                'page'  => $book->page,
                'year'  => $book->year,
                'authors_ids' => $authors,
            ]
        )
            ->assertSessionHas('success', 'The book has been successfully updated')
            ->assertRedirect();


        $this
            ->get(action([BookController::class, 'index']), [])
            ->assertSuccessful()
            ->assertSee('isbn - is - updated');

    }


    public function test_delete_book()
    {
        $book = Book::factory()->count(1)->create([
            'title' => 'new book title - removed'
        ])->first();

        $this
            ->delete(action([BookController::class, 'destroy'], $book->id), [])
            ->assertRedirect();

        $this
            ->get(action([BookController::class, 'edit'], $book->id), [])
            ->assertNotFound();

        $this
            ->get(action([BookController::class, 'index']), [])
            ->assertSuccessful()
            ->assertDontSee('new book title - removed');

    }


    public function test_required_fields_are_validated()
    {

        $book = Book::factory()->count(1)->create([
            'isbn' => 'very old isbn'
        ])->first();
        $authors = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $this->put(
            action([BookController::class, 'update'], $book->id),
            []
        )
            ->assertSessionHasErrors(['isbn', 'title', 'price', 'page', 'authors_ids', 'year']);

        $this->put(
            action([BookController::class, 'update'], $book->id),
            [
                'isbn' => $book->isbn,
                'title'  => $book->title,
                'price' => 200,
                'page'  => $book->page,
                'year'  => $book->year,
                'authors_ids' => $authors,
        ]
        )->assertSessionHasNoErrors();


    }
}
