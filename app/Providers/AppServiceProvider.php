<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if(Session::has('siteSetting')){
            Config::set('siteSetting', Session::get('siteSetting'));
            $website = '127.0.0.1';
            //preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $matches); if($matches){ if($matches[0] != $website){  header("Location: /"); exit(); } }
        }else{
            Session::put('siteSetting', GeneralSetting::first());
            Config::set('siteSetting', GeneralSetting::first());
        }
        view()->share('siteSetting', Session::get('siteSetting'));
    }
}
