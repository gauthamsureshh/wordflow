<!DOCTYPE html>
<html>
<head>
    <title>New Blog Post Created</title>
</head>
<body>
    <h1>New Blog Post Created</h1>
    <p>A new post has been created:</p>
    <h2>{{ $post->title }}</h2>
    <p>{{ Str::limit($post->content, 150) }}</p>
    <p>Posted by: {{ $post->user->name }}</p>
    <p>Category: {{ $post->category->name ?? 'Uncategorized' }}</p>
    <p>Posted on: {{ $post->created_at->format('M d, Y') }}</p>
</body>
</html>
