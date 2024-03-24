<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewCommentNotification;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        return view('comments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);
    
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();
        $comment->save();
    
        $post = $comment->post()->with('user')->first();
    
        $postOwnerEmail = $post->user->email;
    
        Mail::to($postOwnerEmail)->send(new NewCommentNotification($comment));
    
        return redirect()->back()->with('success', 'Comment created successfully.');
    }
    
    
    public function edit(Comment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('comments.edit', compact('comment'));
    }
    
    public function update(Request $request, Comment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $request->validate([
            'text' => 'required',
        ]);
    
        $comment->update([
            'text' => $request->text,
        ]);
    
        return redirect()->route('posts.index')->with('success', 'Comment updated successfully.');
    }
    public function show(Comment $comment) {
    }

    public function destroy(Comment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $comment->delete();
    
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
