<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Lavary\Menu\Builder;


class SiteController extends Controller
{
    protected $p_rep; //portfolio repository
    protected $s_rep; //slider repository
    protected $a_rep; //articles repository
    protected $m_rep; // menu repository

    protected $template; //имя шаблона

    /**
     * Передаваемые значения во view
     * @var array
     */
    protected $vars = array(); //передаваемые переменные

    protected $bar = false; //sidebar

    protected $contentRigtBar = false;
    protected $contentLeftBar = false;

    /**
     * SiteController constructor.
     * @param MenusRepository $m_rep
     */
    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    /**
     * @return $this
     * @throws \Throwable
     */
    protected function renderOutput()
    {
        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)->with($this->vars);
    }

    /**
     * @return \Lavary\Menu\Builder
     */
    protected function getMenu() : Builder
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
