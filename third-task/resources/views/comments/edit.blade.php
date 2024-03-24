<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <nav>
        <h4>Edit Comment</h4>
        <a href="{{ route('posts.index') }}" class="posts">Posts</a>
    </nav>
    <form action="{{ route('comments.update', ['comment' => $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="text" id="text" placeholder="Text">{{ old('text', $comment->text) }}</textarea>
        @error('text')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Update Comment</button>
    </form>
</body>
</html>
