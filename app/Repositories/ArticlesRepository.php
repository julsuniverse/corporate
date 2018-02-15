<?php

namespace App\Repositories;

use App\Article;
use Gate;

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
     * @param Article|null $article
     * @return bool
     * @throws \Exception
     */
    public function save(array $data, Article $article = null)
    {
        if($article) {
            $model = $article->fill($data);
        } else {
            $model = $this->model->fill($data);
        }
        if(!$model->save())
            throw new \Exception('Saving error');

        return true;
    }

    /**
     * @param Article $article
     * @return array
     */
    public function delete(Article $article)
    {
        if(Gate::denies('delete', $article)) {
            abort(403);
        }

        try {
            if ($article->delete()) {
                return [
                    'status' => 'Материал удален!',
                ];
            }
        } catch (\Exception $e) {
        }
    }

}