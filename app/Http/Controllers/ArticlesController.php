<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use app\services\ArticleService;
use Illuminate\Http\Request;

class ArticlesController extends SiteController
{
    public function __construct(
        ArticleService $articleService,
        PortfoliosRepository $p_rep
    )
    {
        parent::__construct(
            new MenusRepository(new Menu())
        );

        $this->articleService = $articleService;
        $this->p_rep = $p_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }

    public function index()
    {
        $articles = $this->articleService->getArticles();

        return $this->renderOutput();
    }


}
