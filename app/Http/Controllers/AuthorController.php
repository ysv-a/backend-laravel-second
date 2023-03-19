<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount('books')->orderByDesc('id')->paginate(15);


        return view('authors.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::pluck('title', 'id');
        return view('authors.create', ['books' => $books]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorCreateRequest $request)
    {
        $author = new Author;
        $author->first_name = $request->input('first_name');
        $author->last_name = $request->input('last_name');
        $author->patronymic = $request->input('patronymic');
        $author->email = $request->input('email');
        $author->biography = $request->input('biography');
        $author->save();

        $author->books()->sync($request->input('book_ids'));

        return redirect()->route('authors.index')->with('success', 'The author has been successfully created');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $books = Book::pluck('title', 'id');

        $selectedBookIds =  $author->books()->select('id')
        ->get()
        ->map(fn ($book) => $book->id)
        ->all();


        return view('authors.edit', ['author' => $author, 'books' => $books, 'selectedBookIds' => $selectedBookIds]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $author->first_name = $request->input('first_name');
        $author->last_name = $request->input('last_name');
        $author->patronymic = $request->input('patronymic');
        $author->email = $request->input('email');
        $author->biography = $request->input('biography');
        $author->save();

        $author->books()->sync($request->input('book_ids'));

        return back()->with('success', 'The author has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'The author has been successfully removed');
    }
}
