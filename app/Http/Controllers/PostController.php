<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->paginate(15);

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('posts.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $post = new Post;
        $post->name = $request->input('name');
        $post->slug = $request->input('slug');
        $post->excerpt = $request->input('excerpt');
        $post->category_id = $request->input('category');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts.index')->with('success', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id');
        return view('posts.edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        // $this->validate($request, [
        //     'name' => 'required|string',
        //     'slug' => 'required|string',
        //     'content' => 'required|string',
        // ]);


        // $post->fill($request->all());
        // $post->save();

        // $category = Category::findOrFail($request->input('category'));

        $post->name = $request->input('name');
        $post->slug = $request->input('slug');
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category');
        $post->save();
        // dd($request->all());

        return back()->with('success', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'The post has been successfully removed');
    }
}
