<?php

namespace App\Repositories;

use App\Portfolio;

class PortfoliosRepository extends Repository
{
    /**
     * MenusRepository constructor.
     * @param Portfolio $portfolio
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
    }


}