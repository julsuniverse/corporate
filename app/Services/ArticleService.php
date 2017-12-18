<?php

namespace App\Services;

use App\Repositories\ArticlesRepository;

class ArticleService
{
    private $a_rep;

    /**
     * ArticleService constructor.
     * @param ArticlesRepository $a_rep
     */
    public function __construct(ArticlesRepository $a_rep)
    {
        $this->a_rep = $a_rep;
    }

    /**
     * @param bool $alias
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getArticles($alias = false): \Illuminate\Database\Eloquent\Collection
    {
        $articles = $this->a_rep->get('*', null, 2);

        return $articles;
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getPreview(): \Illuminate\Database\Eloquent\Collection
    {
        $articles = $this->a_rep->get(['title', 'created_at', 'img', 'alias'],
            \Config::get('settings.home_articles_count'));

        return $articles;
    }
}

