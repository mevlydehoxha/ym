<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <nav>
        <h4>Edit Post</h4>
        <a href="{{ route('posts.index') }}" class="posts">Posts</a>
    </nav>
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="title" id="title" placeholder="Title" value="{{ old('title', $post->title) }}">
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
        <textarea name="text" id="text" placeholder="Text">{{ old('text', $post->text) }}</textarea>
        @error('text')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Update Post</button>
    </form>
</body>
</html>
