<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $p_rep; //portfolio repository
    protected $s_rep; //slider repository
    protected $a_rep; //articles repository
    protected $m_rep; // menu repository

    protected $template; //имя шаблона

    protected $vars = array(); //передаваемые переменные

    protected $bar = false; //sidebar

    protected $contentRigtBar = false;
    protected $contentLeftBar = false;

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
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

        //dd($mBuilder);

        return $mBuilder;
    }

}
