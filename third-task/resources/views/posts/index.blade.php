<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <nav>
        <a class="main" href="{{route('posts.index')}}"><h4>Posts</h4></a>
        <a href="{{ route('posts.create') }}" class="posts">Create Posts</a>
    </nav>
    @auth
    <a href="{{ route('logout') }}" class="logout posts-logout"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth
    <form class="search-form" action="{{ route('posts.search') }}" method="GET">
        <input type="text" name="query" placeholder="Search posts">
        <button type="submit">Search</button>
    </form>

    @if(!empty($query))
        <p>Search results for: <strong>{{ $query }}</strong></p>
    @endif

    <div class="posts-container">
        @if($posts->isEmpty())
            <p class="no-post">No posts available</p>
        @else
            @foreach($posts as $post)
                <div class="inner-container">
                    <div class="top">
                        <h3 class="title">{{$post->title}}</h3>
                        <div>
                            <p class="small">{{$post->user->email}}</p>
                            <p class="small-small">{{$post->created_at}}</p>
                        </div>
                    </div>
                    <p class="text">{{$post->text}}</p>
                    <div class="bottom">
                        @if(Auth::check() && Auth::user()->id === $post->user_id && $post->comments->isEmpty())
                            <a class="edit" href="{{ route('posts.edit', ['post' => $post->id]) }}" class="edit-button">Edit</a>
                            <form class="delete-form" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Delete</button>
                            </form>
                        @endif
                    </div>
                    <div class="comments-section">
                        <h5>Comments</h5>
                        @if($post->comments->isEmpty())
                            <p class="no-comment">No comments yet.</p>
                        @else
                            <div>
                                @foreach($post->comments as $comment)
                                    <div class="comment">
                                        <p class="comment-email">{{ $comment->user->email }}</p>
                                        <p>{{ $comment->text }}</p>
                                        @if(Auth::check() && Auth::user()->id === $comment->user_id)
                                            <div class="comment-actions">
                                                <a href="{{ route('comments.edit', ['comment' => $comment->id]) }}" class="edit">Edit</a>
                                                <form class="delete-form" action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @auth
                        <form class="comment-section" action="{{ route('comments.store') }}" method="POST" class="comment-form">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea name="text" placeholder="Add comment..." required></textarea>
                            <button type="submit">Post Comment</button>
                        </form>
                    @endauth
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
