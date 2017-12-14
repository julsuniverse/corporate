<?php

namespace App\Repositories;

use App\Menu;

class MenusRepository extends Repository
{
    /**
     * MenusRepository constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }


}