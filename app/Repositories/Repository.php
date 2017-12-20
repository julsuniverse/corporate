<?php

namespace App\Repositories;

use App\Article;
use Config;
use Illuminate\Database\Eloquent\Collection;

abstract class Repository
{
    protected $model = false;


    /**
     * @param mixed $select
     * @param int|null $take
     * @param int|null $pagination
     * How to orderBy query. default: id DESC
     * @param array|null $where
     * @param bool $desc
     * @return bool|Collection| \Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(
        $select = '*',
        ?int $take = null,
        ?int $pagination = null,
        ?array $where = null,
        bool $desc = true
    ) {
        $builder = $this->model->select($select);

        if ($where) {
            $builder->where($where[0], $where[1]);
        }
        if ($take) {
            $builder->take($take);
        }
        if ($desc) {
            $builder->orderBy('id', 'DESC');
        }

        if ($pagination) {
            return $this->check($builder->paginate($pagination));
        }

        return $this->check($builder->get());
    }

    public function one($alias, $attr = array())
    {
        return $this->model->where('alias', $alias)->first();
    }

    /**
     * @param $result
     * @return bool|string
     */
    protected function check($result)
    {
        if ($result->isEmpty()) {
            return false;
        }


        $result->transform(function ($item, $key) {
            if (is_string($item->img) && is_object(json_decode($item->img)) && json_last_error() == JSON_ERROR_NONE) {
                $item->img = json_decode($item->img);
            }
            return $item;
        });

        return $result;
    }

}