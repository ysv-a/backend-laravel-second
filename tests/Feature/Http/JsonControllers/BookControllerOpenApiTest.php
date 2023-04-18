<?php

namespace Tests\Feature\Http\JsonControllers;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\OpenApi\BookController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerOpenApiTest extends TestCase
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


    public function test_json_swagger_book_index()
    {
        Book::factory()->count(5)->create();

        $this->get(action([BookController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', 5)
                    ->where('meta.totalCount', 5)
                    ->has('data.0', function (AssertableJson $json) {
                        $json
                            ->has('id')
                            ->has('isbn')
                            ->has('title')
                            ->has('price')
                            ->has('page')
                            ->has('year')
                            ->has('excerpt')
                            ->has('authors')
                            ->etc();
                    })
                ;
            });
    }


    public function test_json_swagger_book_show()
    {
        $book = Book::factory()->count(1)->create()->first();

        $this->get(action([BookController::class, 'show'], $book->id))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', function (AssertableJson $json) {
                        $json
                        ->has('id')
                        ->has('isbn')
                        ->has('title')
                        ->has('price')
                        ->has('page')
                        ->has('year')
                        ->has('excerpt')
                        ->has('authors');
                    })
                ;
            });
    }


    public function test_json_swagger_book_store()
    {
        $authors = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $this
            ->post(action([BookController::class, 'store']), [
                'isbn' => '546546546546546546465',
                'title'  => 'asdasdasdasdasd',
                'price' => 200,
                'page'  => 200,
                'year'  => 1992,
                'authors_ids' => $authors,
            ])
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_CREATED);


        $this->get(action([BookController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->where('meta.totalCount', 1)
                    ->has('data.0', function (AssertableJson $json) {
                        $json
                        ->has('id')
                        ->has('isbn')
                        ->has('title')
                        ->has('price')
                        ->has('page')
                        ->has('year')
                        ->has('excerpt')
                        ->has('authors')
                        ->etc();
                    })
                ;
            });
    }


    public function test_json_swagger_book_update()
    {
        $authors = Author::factory()->count(2)->create()->pluck('id')->toArray();
        $book = Book::factory()->count(1)->create()->first();

        $this
            ->put(action([BookController::class, 'update'], $book->id), [
                'isbn' => '546546546546546546465',
                'title'  => 'book title has been updated',
                'price' => 240,
                'page'  => 240,
                'year'  => 1992,
                'authors_ids' => $authors,
            ])
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_OK);

        $this->get(action([BookController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->where('meta.totalCount', 1)
                    ->where('data.0.title', 'book title has been updated')
                ;
            });
    }


    public function test_json_swagger_book_delete()
    {
        $book = Book::factory()->count(1)->create()->first();

        $this
            ->delete(action([BookController::class, 'delete'], $book->id))
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_NO_CONTENT);


        $this->get(action([BookController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                ->has('data', 0)
                ->where('meta.totalCount', 0);
            });
    }
}
