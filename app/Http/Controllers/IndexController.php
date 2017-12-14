<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;

class IndexController extends SiteController
{

    public function __construct(
        SlidersRepository $s_rep
    ) {
        parent::__construct(
            new MenusRepository(new Menu())
        );

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
        $this->s_rep = $s_rep;
    }

    public function index()
    {
        $sliderItems = $this->getSliders();
        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);
        return $this->renderOutput();
    }

    public function getSliders()
    {
        $sliders = $this->s_rep->get();

        if ($sliders->isEmpty()) {
            return false;
        }
        $sliders->transform(function ($item, $key) {
            $item->img = \Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });

        return $sliders;
    }

}
