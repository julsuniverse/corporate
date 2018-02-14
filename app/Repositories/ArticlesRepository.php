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

    public function one($alias, $attr = array())
    {
        $article = parent::one($alias, $attr);

        if($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function save(array $data)
    {
        $this->model->fill($data);
        if(!$this->model->save())
            throw new \Exception('Saving error');

        return true;
    }

}