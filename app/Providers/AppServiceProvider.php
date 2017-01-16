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


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('articles.detail', 'App\Http\ViewComposers\ArticleComposer');
//        View::composer('articles.detailreview', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('articles.seconddetail', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('articles.ldjl', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('subscribe.ldjl', 'App\Http\ViewComposers\ArticleComposer');
        View::composer('subscribe.detail', 'App\Http\ViewComposers\ArticleComposer');
    }
}
