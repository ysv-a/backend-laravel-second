<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Mail\NewBook;
use App\Models\Author;
use Illuminate\Http\Request;
use App\UseCase\Book\BookService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('authors')->orderByDesc('id')->paginate(15);


        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::select('id', 'first_name', 'last_name', 'patronymic')->get();
        $authors = $authors->mapWithKeys(fn ($author) => [$author->id => "{$author->first_name} {$author->last_name} {$author->patronymic}"]);

        return view('books.create', ['authors' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(BookCreateRequest $request, BookService $bookService)
     {
        $dto = $request->getDto();

        $book = $bookService->create($dto, $request->bookFileDto());


        return redirect()->route('books.edit', ['book' => $book])->with('success', 'The book has been successfully created');
     }

    // public function store(BookCreateRequest $request)
    // {
    //     $path = '';
    //     if ($request->hasFile('image')) {
    //         $path = Storage::putFile('uploads', $request->image);
    //     }

    //     $book = new Book;
    //     $book->isbn = $request->input('isbn');
    //     $book->title = $request->input('title');
    //     $book->price = $request->input('price');
    //     $book->page = $request->input('page');
    //     $book->year = $request->input('year');
    //     $book->excerpt = $request->input('excerpt');
    //     $book->image = $path;
    //     $book->save();

    //     $ids = [];
    //     foreach ($request->input('authors') as $authorInput) {
    //         if(empty($authorInput['first_name'])){
    //             continue;
    //         }

    //         $author = new Author;
    //         $author->first_name = $authorInput['first_name'];
    //         $author->last_name = $authorInput['last_name'];
    //         $author->patronymic = $authorInput['patronymic'];
    //         $author->email = $authorInput['email'];
    //         $author->save();
    //         $ids[] = $author->id;
    //     }
    //     $ids = [...$ids, ...$request->input('authors_ids')];

    //     $book->authors()->sync($ids);

    //     Mail::send(new NewBook($book));

    //     return redirect()->route('books.edit', ['book' => $book])->with('success', 'The book has been successfully created');
    // }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::select('id', 'first_name', 'last_name', 'patronymic')->get();
        $authors = $authors->mapWithKeys(fn ($author) => [$author->id => "{$author->first_name} {$author->last_name} {$author->patronymic}"]);

        $selectedAuthorsIds = $book->authors
        ->map(fn ($author) => $author->id)
        ->all();


        return view('books.edit', [
            'book' => $book,
            'authors' => $authors,
            'selectedAuthorsIds' => $selectedAuthorsIds
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book, BookService $bookService)
    {

        $dto = $request->getDto();

        $bookService->update($book->id, $dto, $request->bookFileDto());

        return back()->with('success', 'The book has been successfully updated');
    }


    // public function update(BookUpdateRequest $request, Book $book)
    // {
    //     $path = '';
    //     if ($request->hasFile('image')) {
    //         $path = Storage::putFile('uploads', $request->image);
    //     }

    //     if ($path && $book->image) {
    //         Storage::delete($book->image);
    //     }

    //     $book->isbn = $request->input('isbn');
    //     $book->title = $request->input('title');
    //     $book->price = $request->input('price');
    //     $book->page = $request->input('page');
    //     $book->year = $request->input('year');
    //     $book->excerpt = $request->input('excerpt');
    //     $book->image = $path;
    //     $book->save();

    //     $book->authors()->sync($request->input('authors_ids'));


    //     return back()->with('success', 'The book has been successfully updated');
    // }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'The book has been successfully removed');
    }


    public function publish(Book $book, BookService $bookService)
    {
        $bookService->publish($book->id);
        return redirect()->route('books.index')->with('success', 'The book has been successfully published');
    }
}
