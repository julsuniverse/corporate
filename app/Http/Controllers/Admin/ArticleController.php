<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\MenuService;

class ArticleController extends AdminController
{
    private $categoryService;

    public function __construct(
        MenuService $menuService,
        ArticleService $articleService,
        CategoryService $categoryService
    )
    {
        parent::__construct($menuService);

        $this->template = env('THEME').'.admin.articles';
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ArticleController
     * @throws \Throwable
     */
    public function index()
    {
        $this->title = "Статьи";
        $articles = $this->articleService->getAll();

        $this->content = view(env('THEME').'.admin.articles_content')
            ->with('articles', $articles)
            ->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ArticleController
     * @throws \Throwable
     */
    public function create()
    {
        $this->title = "Create article";

        $lists = $this->categoryService->get();

        $this->content = view(env('THEME').'.admin.articles_create_content')
            ->with('categories', $lists)
            ->render();
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->articleService->save($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        echo "show: ".$alias;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return ArticleController
     * @throws \Throwable
     */
    public function edit(Article $article)
    {
        $article->img = json_decode($article->img);
        $lists = $this->categoryService->get();
        $this->title = 'Редактирование материала: ' . $article->title;

        $this->content = view(env('THEME').'.admin.articles_create_content')
            ->with([
                'categories' => $lists,
                'article' => $article,
            ])
            ->render();
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->articleService->save($request, $article);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
