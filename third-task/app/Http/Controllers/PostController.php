<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\VerifyEmail;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }
    

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
    
        $post = new Post();
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = Auth::id(); 
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        if (!$post->comments->isEmpty()) {
            return redirect()->back()->with('error', 'Cannot edit post with comments.');
        }
    
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }
    
   public function destroy(Post $post)
    {
        if (!$post->comments->isEmpty()) {
            return redirect()->back()->with('error', 'Cannot delete post with comments.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    public function search(Request $request)
{
    $query = $request->input('query');

    $posts = Post::where('title', 'like', "%$query%")
                ->orWhere('text', 'like', "%$query%")
                ->orWhereHas('comments', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('text', 'like', "%$query%");
                })
                ->get();

    return view('posts.index', compact('posts', 'query'));
}


}