<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <nav>
        <h4>Create Post</h4>
        <a href="{{ route('posts.index') }}" class="posts">Posts</a>
    </nav>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <input type="text" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
        <textarea name="text" id="text" placeholder="Text">{{ old('text') }}</textarea>
        @error('text')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Create Post</button>
    </form>
</body>
</html>
