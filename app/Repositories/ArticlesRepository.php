<?php

namespace App\Repositories;

use App\Article;

class ArticlesRepository extends Repository
{
    /**
     * MenusRepository constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->model = $article;
    }


}