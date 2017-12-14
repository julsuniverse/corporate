<?php

namespace App\Repositories;

use App\Slider;

class SlidersRepository extends Repository
{
    /**
     * SlidersRepository constructor.
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }


}