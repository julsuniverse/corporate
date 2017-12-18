<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\MenuService;
use App\Services\PortfolioService;
use App\Services\SliderService;
use Illuminate\Http\Request;

class IndexController extends SiteController
{
    /**
     * IndexController constructor.
     * @param SliderService $sliderService
     * @param PortfolioService $portfolioService
     * @param ArticleService $articleService
     * @param MenuService $menuService
     */
    public function __construct(
        SliderService $sliderService,
        PortfolioService $portfolioService,
        ArticleService $articleService,
        MenuService $menuService
    ) {
        parent::__construct(
            $menuService
        );

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';

        $this->sliderService = $sliderService;
        $this->portfolioService = $portfolioService;
        $this->articleService = $articleService;
    }

    /**
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function index(): \Illuminate\view\view
    {
        $sliderItems = $this->sliderService->getSliders();
        $sliders = view(env('THEME') . '.slider')
            ->with('sliders', $sliderItems)
            ->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);

        $portfolios = $this->portfolioService->getPortfolio();
        $content = view(env('THEME') . '.content')
            ->with('portfolios', $portfolios)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $articles = $this->articleService->getPreview();
        $this->contentRigtBar = view(env('THEME') . '.indexBar')
            ->with('articles', $articles)
            ->render();

        return $this->renderOutput();
    }


}
