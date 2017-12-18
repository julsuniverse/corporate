<?php

namespace App\Services;

use App\Repositories\MenusRepository;
use Lavary\Menu\Builder;
use App\Menu;

class MenuService
{
    private $m_rep;

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    /**
     * @return \Lavary\Menu\Builder
     */
    public function getMenu(): Builder
    {
        $menu = $this->m_rep->get();

        $mBuilder = \LMenu::make('MyNav', function ($m) use ($menu) {
            foreach ($menu as $item) {

                if ($item->parent_id == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent_id)) {
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }

            }
        });

        return $mBuilder;
    }
}