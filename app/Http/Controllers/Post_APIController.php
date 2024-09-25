<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Post_APIController extends Controller
{
    //fn to return api with all the post entered by users.
    public function index() {
        $posts = Post::with('user', 'category')->get();
        return response()->json($posts);
    }

    //create a new post with api.
    public function store(Request $request)
{

    $request->validate([
        'title' => 'required|string|max:150',
        'content' => 'required|string',
        'category_id' => 'nullable|exists:categories,id',
        'tags' => 'array|exists:tags,id',
        'image' => 'nullable|image|mimes:png,jpg,gif|max:2048'
    ]);


    $post = Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => Auth::id(), 
        'category_id' => $request->category_id,
        'image_path' => $request->hasFile('image') 
            ? $request->file('image')->store('images', 'public') 
            : null
    ]);


    if ($request->tags) {
        $post->tags()->attach($request->tags);
    }

    return response()->json($post, 201);
}

    //fn to update a post 
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'title' => 'sometimes|required|string|max:150',
        'content' => 'sometimes|required|string',
        'category_id' => 'nullable|exists:categories,id',
        'tags' => 'array|exists:tags,id',
        'image' => 'nullable|image|mimes:png,jpg,gif|max:2048'
    ]);

    // Find the post by ID
    $post = Post::findOrFail($id);


    $postData = $request->only(['title', 'content', 'category_id']);


    if ($request->hasFile('image')) {
        $postData['image_path'] = $request->file('image')->store('images', 'public');
    }

    $post->update($postData);


    if ($request->tags) {
        $post->tags()->sync($request->tags);
    }

    return response()->json($post);
}

    // Delete a specific post
    public function destroy($id)
    {
        Post::destroy($id);
    }


}
