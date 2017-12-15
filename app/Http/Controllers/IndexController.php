<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;

class IndexController extends SiteController
{
    /**
     * IndexController constructor.
     * @param SlidersRepository $s_rep
     * @param PortfoliosRepository $p_rep
     */
    public function __construct(
        SlidersRepository $s_rep,
        PortfoliosRepository $p_rep
    ) {
        parent::__construct(
            new MenusRepository(new Menu())
        );

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
    }

    /**
     * @return $this
     * @throws \Throwable
     */
    public function index()
    {
        $sliderItems = $this->getSliders();
        $sliders = view(env('THEME') . '.slider')
            ->with('sliders', $sliderItems)
            ->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);

        $portfolios = $this->getPortfolio();
        $content = view(env('THEME').'.content')
            ->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }


    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getSliders()
    {
        $sliders = $this->s_rep->get();

        if ($sliders->isEmpty()) {
            return false;
        }
        $sliders->transform(function ($item, $key) {
            $item->img = \Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });

        return $sliders;
    }

    protected function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', \Config::get('settings.home_pore_count'));

        return $portfolio;

    }

}
