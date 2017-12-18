<?php

namespace App\Services;

use App\Repositories\CommentsRepository;

class CommentService
{
    private $repository;

    public function __construct(CommentsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRecent($take)
    {
        $comments = $this->repository->get(['name', 'text', 'email', 'site', 'article_id', 'user_id'], $take);

        if($comments)
            $comments->load('article', 'user');
        return $comments;
    }
}