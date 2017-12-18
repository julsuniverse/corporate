<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\CommentService;
use App\Services\MenuService;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

class ArticleController extends SiteController
{
    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     * @param PortfolioService $portfolioService
     * @param MenuService $menuService
     * @param CommentService $commentService
     */
    public function __construct(
        ArticleService $articleService,
        PortfolioService $portfolioService,
        MenuService $menuService,
        CommentService $commentService
    ) {
        parent::__construct($menuService);

        $this->articleService = $articleService;
        $this->portfolioService = $portfolioService;
        $this->commentService = $commentService;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }


    /**
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function index()
    {
        $articles = $this->articleService->getArticles();

        $content = view(env('THEME') . '.articles_content')
            ->with('articles', $articles)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->commentService->getRecent(config('settings.recent_comments'));
        $portfolios = $this->portfolioService->getPreview(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME').'.articles_bar')
            ->with([
                'comments' => $comments,
                'portfolios' => $portfolios,
            ])
            ->render();

        return $this->renderOutput();
    }


}
