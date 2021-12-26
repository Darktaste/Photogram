<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
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
    
    
    public function destroy(Request $request, Comment $comment)
    {   
 
        if ($request->user()->cannot('delete', $comment)) {
            abort(403);
        }
        
       $query =  $comment->delete();
        
       if($query) {
        return response()->json([
            'status' => 200, 
            'result' => true,
            ]);
       } else {
           return responce()->json([
               'status' => 400,
               'result' => false,
           ]);
       }        
    }
}