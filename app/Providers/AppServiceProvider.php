<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @set($i, 10)
        Blade::directive('set', function($exp) {
            list($name, $val) = explode(', ', $exp);
            return "<?php $name = $val ?>";
        });

        $this->publishes([
            base_path('vendor/components')  => public_path('assets'),
            base_path('vendor/grimmlink')  => public_path('assets'),
        ], 'public');

        /*DB::listen(function($query){
            echo '<h1>'.$query->sql.'</h1>';
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
