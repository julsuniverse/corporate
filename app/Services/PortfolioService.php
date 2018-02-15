<?php

namespace App\Services;

use App\Repositories\PortfoliosRepository;

class PortfolioService
{
    private $repository;

    public function __construct(PortfoliosRepository $p_rep)
    {
        $this->repository = $p_rep;
    }

    /**
     * @param $take
     * @return bool|\Illuminate\Database\Eloquent\Collection
     */
    public function getPreview($take)
    {
        $portfolio = $this->repository->get('*', $take);

        return $portfolio;
    }

    public function getPortfolios($take = false, $paginate = true)
    {

        $portfolios = $this->repository->get('*', $take, $paginate);
        if ($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }

}