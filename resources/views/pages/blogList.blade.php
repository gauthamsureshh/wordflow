@extends('layouts.main')

@section('title','WordFlow')
@section('content')
    <div class="container">
        <h1 class="mb-4">Journey Through Words</h1>
        <a href="{{ route('createblog') }}" class="btn btn-info mb-2">Create Post</a>
        @if ($posts->count())
            @foreach ($posts as $post)
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        @if(Auth::id() === $post->user_id)
                        <div class="float-end">
                            <a href="{{ route('editblog', $post->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('blog.delete', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                    @endif
                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                        <p class="text-muted">
                            Posted by <strong>{{ $post->user->name }}</strong> 
                            in <em>{{ $post->category->name ?? 'Uncategorized' }}</em> 
                            on {{ $post->created_at->format('M d, Y') }}
                        </p>
                        {{-- <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read More</a> --}}

                       
                    </div>
                </div>
            @endforeach
            {{$posts->links('vendor.pagination.customPagination')}}
        @else
            <p>No blog posts available yet.</p>
        @endif
    </div>
@endsection