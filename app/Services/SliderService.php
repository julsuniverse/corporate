<?php

namespace App\Services;

use App\Repositories\SlidersRepository;

class SliderService
{
    private $s_rep;

    /**
     * SliderService constructor.
     * @param SlidersRepository $s_rep
     */
    public function __construct(SlidersRepository $s_rep)
    {
        $this->s_rep = $s_rep;
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
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