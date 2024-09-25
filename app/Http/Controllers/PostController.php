<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Jobs\SendPostCreatedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;


class PostController extends Controller
{
    //fn to list all the blog_post with realated user.
    public function index() {
        $posts = Post::with(['user', 'category', 'tags'])->latest()->paginate(3);
        return view('pages.blogList',compact('posts'));
    }

    //fn to display the create page of blog+_post.
    public function create() {
        $categories = Category::all();
        $tags = Tag::all();
        return view('pages.blogCreate',compact('categories','tags'));
    }

    //fn to store the blog_post details entered by related user.
    public function store(Request $request) {
        $request-> validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'array|exists:tags,id',
            'image' => 'nullable|image|mimes:png,jpg,gif|max:2048'
        ]);

        $postData = [
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); 
            $postData['image_path'] = $path;
        }

        $post = Post::create($postData);

        if($request->tags) {
            $post->tags()->attach($request->tags);
        }

        $adminEmail = 'enmapictures@gmail.com'; // change mail according to admin mail.

        SendPostCreatedEmail::dispatch($post->id, $adminEmail);;

        return redirect(route('listblog'))->with('success','Post Created Successfully');
    } 

    //fn to display edit page of blog_post.
    public function edit(Post $post) {
        if(Auth::id() !== $post->user_id) {
            return redirect(route('listblog'))->with('error','Unathorized Access');
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('pages.blogUpdate', compact('post','categories','tags'));
    }

    //fn to update details done by the user.
    public function update(Request $request, Post $post) {
        if(Auth::id() !== $post->user_id) {
            return redirect(route('listblog'))->with('error','Unathorized Access');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'array|exists:tags,id',
            'image' => 'nullable|image|mimes:png,jpg,gif|max:2048',
        ]);

        $postData = [
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('images', 'public');
            $postData['image_path'] = $path;
        }

        $post->update($postData);

        $post->tags()->sync($request->tags);

        return redirect(route('listblog'))->with('success','Post Updated Successfully');
    }

    //fn to delete the blog_post related to user.
    public function destroy(Post $post) {
        if(Auth::id() !== $post->user_id) {
            return redirect(route('listblog'))->with('error','Unathorized Access');
        }

        $post->tags()->detach();
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        return redirect(route('listblog'))->with('success','Post Deleted Successfully');
    }
}
