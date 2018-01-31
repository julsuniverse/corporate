<?php

namespace App\Services;

use App\Category;
use App\Repositories\ArticlesRepository;

class ArticleService
{
    private $repository;

    /**
     * ArticleService constructor.
     * @param ArticlesRepository $a_rep
     */
    public function __construct(ArticlesRepository $a_rep)
    {
        $this->repository = $a_rep;
    }

    /**
     * @param bool $alias
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getArticles($alias = false): \Illuminate\Pagination\LengthAwarePaginator
    {
        $where = null;
        if ($alias) {
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->repository->get(
            ['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'],
            null,
            2,
            $where
        );

        if ($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    public function getAll()
    {
        $articles = $this->repository->get(
            ['id', 'title', 'alias', 'created_at', 'img','text', 'desc', 'user_id', 'category_id'],
            null,
            null,
            null
        );

        if ($articles) {
            $articles->load('category', 'comments');
        }

        return $articles;
    }

    public function one($alias, $attr = array())
    {
        $article = $this->repository->one($alias, $attr);
        return $article;
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getPreview(): \Illuminate\Database\Eloquent\Collection
    {
        $articles = $this->repository->get(['title', 'created_at', 'img', 'alias'],
            \Config::get('settings.home_articles_count'));

        return $articles;
    }
}

