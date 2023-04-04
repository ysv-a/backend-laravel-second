<?php

namespace App\Http\Controllers\OpenApi;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Services\FileUploader;
use App\UseCase\Book\BookService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookCollection;
use Symfony\Component\HttpFoundation\Response;

class BookController
{
    #[OA\Get(
        path: '/books',
        summary: "Get list of books",
        tags: ['books'],
    )]
    #[OA\Parameter(
        name: "sort",
        description: "sort",
        in: "query",
        schema: new OA\Schema(
            type: "array",
            items: new OA\Items(
                type: "string",
                enum: ['id', '-id', 'title', 'created_at']
            )
        )
    )]
    #[OA\Parameter(
        name: "filter",
        description: "filter",
        in: "query",
        schema: new OA\Schema(
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer"
                ),
                new OA\Property(
                    property: "slug",
                    type: "string"
                )
            ],
            type: "object"
        ),
        style: "deepObject",
    )]
    #[OA\Parameter(
        name: "offset",
        description: "offset",
        in: "query",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
        examples: [
            new OA\Examples(
                example: 0,
                summary: 0,
                value: 0,
            )
        ]
    )]
    #[OA\Parameter(
        name: "limit",
        description: "limit",
        in: "query",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
        examples: [
            new OA\Examples(
                example: 10,
                summary: 10,
                value: 10,
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: "#/components/schemas/BookResource"
            )
        )
    )]

    public function index(Request $request): BookCollection
    {
        $filters = $request->get('filter');
        $sort = $request->get('sort');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);


        $query = Book::query();

        $query->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id', $id);
        })->when($filters['slug'] ?? null, function ($query, $slug) {
            $query->where('slug', $slug);
        });


        $query->when($sort, function ($query, $sort) {
            $type = 'asc';
            $param = $sort;
            if ($sort[0] === '-') {
                $param = ltrim($param, '-');
                $type = 'desc';
            }
            $query->orderBy($param, $type);
        });

        $books = $query
            ->offset($offset ?? 0)
            ->limit($limit ?? 10)
            ->with('authors')
            ->get();


        return new BookCollection($books);
    }



    #[OA\Get(
        path: '/books/{id}',
        summary: "Get books detail",
        tags: ['books'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "book id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            ref: "#/components/schemas/BookResource"
        )
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Resource Not Found',
    )]
    public function show($id): BookResource
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }


    #[OA\Post(
        path: '/books',
        summary: "Store new book",
        tags: ['books'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            // ref: "#/components/schemas/BookDto"
            required: ['isbn', 'title'],
            properties: [
                new OA\Property(
                    property: "isbn",
                    type: "string",
                ),
                new OA\Property(
                    property: "title",
                    type: "string"
                ),
                new OA\Property(
                    property: "price",
                    type: "number",
                    format: "double"
                ),
                new OA\Property(
                    property: "page",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "year",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "excerpt",
                    type: "string",
                ),
                new OA\Property(
                    property: "base64_image",
                    type: "string",
                ),
                new OA\Property(
                    property: "authors_ids",
                    type: "array",
                    items: new OA\Items(
                        type: "integer"
                    )
                ),
                new OA\Property(
                    property: 'authors',
                    type: "array",
                    items: new OA\Items(
                        ref: "#/components/schemas/AuthorResource"
                    )
                )
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'success',
        content: new OA\JsonContent(
            ref: "#/components/schemas/BookResource"
        )
    )]
    public function store(BookCreateRequest $request, FileUploader $uploader, BookService $bookService): JsonResponse
    {
        $file_path =  $request->input('base64_image') != '' ? $uploader->uploadBase64($request->input('base64_image')) : null;
        $dto = $request->getDto();
        $book = $bookService->create($dto, $file_path);

        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    #[OA\Put(
        path: '/books/{id}',
        summary: "Update existing book",
        tags: ['books'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "book id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "isbn",
                    type: "string"
                ),
                new OA\Property(
                    property: "title",
                    type: "string"
                ),
                new OA\Property(
                    property: "price",
                    type: "number",
                    format: "double"
                ),
                new OA\Property(
                    property: "page",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "year",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "excerpt",
                    type: "string",
                ),
                new OA\Property(
                    property: "authors_ids",
                    type: "array",
                    items: new OA\Items(
                        type: "integer"
                    )
                ),
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'success',
        content: new OA\JsonContent(
            ref: "#/components/schemas/BookResource"
        )
    )]
    public function update(BookUpdateRequest $request, $id, BookService $bookService): JsonResponse
    {
        $dto = $request->getDto();

        $book = $bookService->update($id, $dto);



        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    #[OA\Delete(
        path: '/books/{id}',
        summary: "Delete existing book",
        tags: ['books'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "book id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_NO_CONTENT,
        description: 'success',
        content: new OA\JsonContent()
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Resource Not Found',
    )]
    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
