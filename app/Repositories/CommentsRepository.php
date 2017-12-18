<?php

namespace App\Repositories;

use App\Comment;

class CommentsRepository extends Repository
{
    /**
     * CommentsRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}