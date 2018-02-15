<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user)
    {
        return $user->canDo('ADD_ARTICLES');
    }

    public function edit(User $user)
    {
        return $user->canDo('UPDATE_ARTICLES');
    }

    /**
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Article $article)
    {
        return($user->canDo('DELETE_ARTICLES') && ($user->id == $article->user_id));
    }




}
