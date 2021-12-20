<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comments $comments)
    {
       return $comments->user->id === $user->id || $comments->post->user->id === $user->id;
    }

    
}
