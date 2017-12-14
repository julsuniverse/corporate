<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;

class IndexController extends SiteController
{

    public function __construct()
    {
        parent::__construct(
            new MenusRepository(new Menu())
    );

        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }

    public function index()
    {
        return $this->renderOutput();
    }

}
