<?php

namespace App\Services;


use App\Repositories\CategoryRepository;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function get()
    {
        $categories = $this->repository->get();

        $lists = array();
        foreach($categories as $category) {
            if ($category->parent_id == 0) {
                if(!isset($lists[$category->title]))
                    $lists[$category->title] = array();
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        return $lists;
    }
}