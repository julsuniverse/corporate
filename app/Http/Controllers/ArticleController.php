<?php

namespace App\Http\Controllers;

use App\Repositories\ArticlesRepository;
use App\Services\ArticleService;
use App\Services\CommentService;
use App\Services\MenuService;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

class ArticleController extends SiteController
{
    private $articlesRepository;
    /**
     * ArticleController constructor.
     * @param ArticlesRepository $articlesRepository
     * @param PortfolioService $portfolioService
     * @param MenuService $menuService
     * @param CommentService $commentService
     */
    public function __construct(
        ArticleService $articleService,
        ArticlesRepository $articlesRepository,
        PortfolioService $portfolioService,
        MenuService $menuService,
        CommentService $commentService
    ) {
        parent::__construct($menuService);

        $this->articleService = $articleService;
        $this->articlesRepository = $articlesRepository;
        $this->portfolioService = $portfolioService;
        $this->commentService = $commentService;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }


    /**
     * @param bool $cat_alias
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function index($cat_alias = false)
    {
        $articles = $this->articleService->getArticles($cat_alias);

        $content = view(env('THEME') . '.articles_content')
            ->with('articles', $articles)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentRightBar = $this->getRightBar();

        return $this->renderOutput();
    }

    /**
     * @param $alias
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function show($alias)
    {
        $article = $this->articlesRepository->one($alias, ['comments' => true]);
        if($article)
            $article->img = json_decode($article->img);

        $content = view(env('THEME').'.article_content')
            ->with('article', $article)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentRightBar = $this->getRightBar();

        return $this->renderOutput();
    }


    /**
     * @return string
     * @throws \Throwable
     */
    public function getRightBar()
    {
        $comments = $this->commentService->getRecent(config('settings.recent_comments'));
        $portfolios = $this->portfolioService->getPreview(config('settings.recent_portfolios'));
        return view(env('THEME').'.articles_bar')
            ->with([
                'comments' => $comments,
                'portfolios' => $portfolios,
            ])
            ->render();
    }

}
