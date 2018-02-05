<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Repositories\CategoryRepository;
use App\Services\ArticleService;
use App\Services\MenuService;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{
    private $categoryRepository;

    public function __construct(
        MenuService $menuService,
        ArticleService $articleService,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($menuService);

        $this->template = env('THEME').'.admin.articles';
        $this->articleService = $articleService;
        $this->categoryRepository = $categoryRepository;
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
     * @return ArticleController
     * @throws \Throwable
     */
    public function create()
    {
        $this->title = "Create article";
        $categories = $this->categoryRepository->get();

        $lists = array();
        foreach($categories as $category) {
            if ($category->parent_id == 0) {
                if(!isset($lists[$category->title]))
                    $lists[$category->title] = array();
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;//[$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME').'.admin.articles_create_content')
            ->with('categories', $lists)
            ->render();
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->articleService->save($request);

        if(is_array($request) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('admin')->with($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        echo "show: ".$alias;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($alias)
    {
        echo "edit: ".$alias;
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
