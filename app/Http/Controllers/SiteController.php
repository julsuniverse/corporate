<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    protected $portfolioService;
    protected $sliderService;
    protected $articleService;
    protected $menuService;

    protected $template; //имя шаблона

    /**
     * Передаваемые значения во view
     * @var array
     */
    protected $vars = array(); //передаваемые переменные

    protected $bar = 'no'; //sidebar

    protected $contentRigtBar = false;
    protected $contentLeftBar = false;

    /**
     * SiteController constructor.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * @return \Illuminate\view\view
     * @throws \Throwable
     */
    protected function renderOutput(): \Illuminate\view\view
    {
        $menu = $this->menuService->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        if ($this->contentRigtBar) {
            $rightBar = view(env('THEME') . '.rightBar')
                ->with('contentRightBar', $this->contentRigtBar)
                ->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $footer = view('pink.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }


}
