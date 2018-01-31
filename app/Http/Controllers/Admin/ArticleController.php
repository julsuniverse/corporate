<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\MenuService;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{
    public function __construct(
        MenuService $menuService,
        ArticleService $articleService
    )
    {
        parent::__construct($menuService);

        $this->template = env('THEME').'.admin.articles';
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ArticleController
     * @throws \Throwable
     */
    public function index()
    {
        $this->title = "Статьи";
        $articles = $this->articleService->getAll();

        $this->content = view(env('THEME').'.admin.articles_content')
            ->with('articles', $articles)
            ->render();
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
