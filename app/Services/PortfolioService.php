<?php

namespace App\Services;

use App\Repositories\PortfoliosRepository;

class PortfolioService
{
    private $p_rep;

    public function __construct(PortfoliosRepository $p_rep)
    {
        $this->p_rep = $p_rep;
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', \Config::get('settings.home_port_count'));

        return $portfolio;
    }
}