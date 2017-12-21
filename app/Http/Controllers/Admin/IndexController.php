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
    }

    public function index()
    {
        $this->title = 'Панель управления';
        return $this->renderOutput();
    }
}
