<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer('articles.detail', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('articles.detailreview', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('articles.seconddetail', 'App\Http\ViewComposers\ArticleComposer');
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
