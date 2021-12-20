<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Models\User;
use App\Models\Post;



class CommentController extends Controller
{
    
    
    
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();
        $comment = new Comment();
        $comment->text = strip_tags($validated['text']);
        $comment->user()->associate(auth()->user());
        $comment->post()->associate($post);
        $comment->saveOrFail();
    
        return back();
   
    }
    
    
    public function destroy($id)
    {   
        $comment = Comment::where('id', $id);
        $comment->delete();
        
        return response()->json([
            'status' => 200, 
            'result' => 'successfu;ly deleted',
            ]);
        
             
    }
}