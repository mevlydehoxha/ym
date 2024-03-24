<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Comment Notification</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <h2 class="new-comment-email">You have a new comment</h2>
    
    @if ($comment->post)
        <p class="email-text"><strong>Post Title - </strong> {{ $comment->post->title }}</p>
    @else
        <p class="email-text"><strong>Post Title - </strong> Unknown</p>
    @endif
    
    <p class="email-text"><strong>Comment - </strong> {{ $comment->text }}</p>
</body>
</html>
