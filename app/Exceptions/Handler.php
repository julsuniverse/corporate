<?php

namespace App\Exceptions;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Services\MenuService;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            $code = $exception->getStatusCode();
            if($code == 404) {
                $menu = new MenuService(new MenusRepository(new Menu()));
                $menu = $menu->getMenu();
                $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
                \Log::alert('Page not found: ' . $request->url());
                return response()->view(env('THEME').'.errors.404', [
                    'bar' => 'no',
                    'title' => '404 Not Found',
                    'navigation' => $navigation,
                ]);
            }


        }
        return parent::render($request, $exception);
    }
}
