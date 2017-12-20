<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Auth;
use Illuminate\Http\Request;
use Validator;

class CommentController extends SiteController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    //TODO: do refactor!!!
    public function store(Request $request)
    {
        $data = $request->except('_token', 'comment_post_ID', 'comment_parent');
        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        $validator = Validator::make($data, [
            'article_id' => 'integer|required',
            'parent_id' => 'integer|required',
            'text' => 'string|required',
        ]);

        $validator->sometimes(['name', 'email'], 'required|max:255', function ($input) {
            return !Auth::check();
        });

        if ($validator->fails()) {
            return \Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        //TODO: move business logic into service
        $comment = new Comment($data);
        if ($user) {
            $comment->user_id = $user->id;
        }
        //TODO: save comment with Comment model, not with Article model
        // $comment->article_id = ($data['article_id'];
        // $comment->parent_id = $data['parent_id'];
        //$comment->save();

        $post = Article::find($data['article_id']);
        $post->comments()->save($comment);

        $comment->load('user');
        $data['id'] = $comment->id;
        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;
        $data['hash'] = md5($data['email']);

        $view_comment = view(env('THEME').'.content_one_comment')
            ->with('data', $data)
            ->render();

        return \Response::json([
            'success' => true,
            'comment' => $view_comment,
            'data' => $data,
        ]);

        exit();

    }
}
