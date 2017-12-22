<?php

namespace App\Http\Controllers\Admin;

use App\Services\MenuService;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    public function __construct(MenuService $menuService)
    {
        parent::__construct($menuService);

        $this->template = env('THEME').'.admin.index';
    //dd(\Gate::denies('VIEW_ADMIN'));
        /*
         * if(\Gate::denies('VIEW_ADMIN')) {
            abort(403);
        }
         */

    }

    public function index()
    {
        if(\Gate::denies('VIEW_ADMIN')) {
            abort(403);
        }
        $this->title = 'Панель управления';
        return $this->renderOutput();
    }
}
