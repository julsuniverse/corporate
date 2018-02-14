<?php

namespace App\Services;

use App\Category;
use App\Helpers\Translit;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticlesRepository;
use Intervention\Image\Facades\Image;

class ArticleService
{
    private $repository;

    /**
     * ArticleService constructor.
     * @param ArticlesRepository $articlesRepository
     */
    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->repository = $articlesRepository;
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

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
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

    /**
     * @param ArticleRequest $request
     * @return array|string
     */
    public function save($request)
    {
        $data = $request->except('_token', 'image');
        if(empty($data['alias']))
            $data['alias'] = Translit::translit($data['title']);

        if($this->one($data['alias'], false)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Данный псевдоним уже используется'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()) {
                $str = str_random(8);

                $obj = new \stdClass();
                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                /** @var \Intervention\Image\Image $img */
                $img = Image::make($image);

                $img->fit(
                    \Config::get('settings.image.width'),
                    \Config::get('settings.image.height')
                )->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->path);

                $img->fit(
                    \Config::get('settings.articles_img.max.width'),
                    \Config::get('settings.articles_img.max.height')
                )->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->max);

                $img->fit(
                    \Config::get('settings.articles_img.mini.width'),
                    \Config::get('settings.articles_img.mini.height')
                )->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);
                $data['user_id'] = \Auth::id();

                try{
                    if($this->repository->save($data))
                        return [
                        'status' => 'Материал сохранен'
                    ];
                } catch(\Exception $exception) {
                    return $exception->getMessage();
                }
            }
        }
    }

}

