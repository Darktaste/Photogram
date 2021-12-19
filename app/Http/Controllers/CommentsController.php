<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Http\Requests\StoreCommentsRequest;
use App\Models\User;
use App\Models\Post;
use App\Policies\CommentsPolicy;
use App\Http\Controllers\PostController;



class CommentsController extends Controller
{
    
    
    
    public function store(StoreCommentsRequest $request, Post $post)
    {
        $validated = $request->validated();
        $comment = new Comments();
        $comment->text = strip_tags($validated['text']);
        $comment->user()->associate(auth()->user());
        $comment->post()->associate($post);
        $comment->saveOrFail();
    
        return back();
   
    }
    
    
    public function destroy($id)
    {   
        
        
        $comment = Comments::where('id', $id);
        
        $comment->delete();
         
        return response(''. 204);
    }
}