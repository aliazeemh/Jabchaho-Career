<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cms;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if(env('FORCE_HTTPS',false)) { // Default value should be false for local server
            URL::forceScheme('https');
        }
        
        \View::composer('frontend.layouts.navbar', function($view)
        {
            $cmsObject = new Cms();
            $cmsPages  = $cmsObject->getPages();
            $view->with('cmsPages', $cmsPages); // you can pass array here aswell
        });


        \View::composer('frontend.layouts.footer', function($view)
        {
            $cmsObject = new Cms();
            $cmsPages  = $cmsObject->getPages();
            $view->with('cmsPages', $cmsPages); // you can pass array here aswell
        });
    }
}
