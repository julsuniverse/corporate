<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\Repositories\PortfoliosRepository;
use App\Services\MenuService;
use App\Services\PortfolioService;
use Route;

class PortfolioController extends SiteController
{
    private $portfoliosRepository;

    public function __construct(
        MenuService $menuService,
        PortfolioService $portfolioService,
        PortfoliosRepository $portfoliosRepository
    ) {
        parent::__construct($menuService);

        $this->portfolioService = $portfolioService;
        $this->portfoliosRepository = $portfoliosRepository;
        $this->template = env('THEME') . '.portfolios';
    }

    /**
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function index()
    {
        $portfolios = $this->portfolioService->getPortfolios();

        $content = view(env('THEME') . '.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);


        return $this->renderOutput();
    }

    /**
     * @param $alias
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    public function show(Portfolio $portfolio)
    {
        //dd(Route::current());
        //$portfolio = $this->portfoliosRepository->one($alias);
        $portfolio->img = json_decode($portfolio->img);
        $portfolios = $this->portfolioService->getPortfolios(config('settings.other_portfolios'), false);

        $content = view(env('THEME') . '.portfolio_content')->with([
            'portfolio' => $portfolio,
            'portfolios' => $portfolios
        ])->render();
        $this->vars = array_add($this->vars, 'content', $content);
        return $this->renderOutput();
    }
}
