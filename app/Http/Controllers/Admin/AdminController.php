<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $portfolioService;
    protected $sliderService;
    protected $articleService;
    protected $menuService;

    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars;

    /**
     * AdminController constructor.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->user = \Auth::user();

       // if(!$this->user)
       //     abort(403);

        $this->menuService = $menuService;
    }

    /**
     * @return $this
     * @throws \Throwable
     */
    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);
        $menu = $this->menuService->getAdmin();
        $navigation = view(env('THEME').'.admin.navigation')
            ->with('menu', $menu)
            ->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->content)
            $this->vars = array_add($this->vars, 'content', $this->content);

        $footer = view(env('THEME').'.admin.footer')
            ->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }


}
