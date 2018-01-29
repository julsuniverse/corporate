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
        $menu = $this->m_rep->get('*', null, null, null,false);

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

    /**
     * @return \Lavary\Menu\Builder
     */
    public function getAdmin(): Builder
    {
        $mBuilder = \LMenu::make('adminMenu', function ($menu) {
            $menu->add('Статьи', array('route' => 'admin.articles.index'));
            $menu->add('Портфолио', array('route' => 'admin.articles.index'));
            $menu->add('Меню', array('route' => 'admin.articles.index'));
            $menu->add('Пользователи', array('route' => 'admin.articles.index'));
            $menu->add('Привилегии', array('route' => 'admin.articles.index'));


        });

        return $mBuilder;
    }

}