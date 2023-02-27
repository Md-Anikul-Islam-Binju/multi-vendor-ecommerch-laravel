<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        // for admin route
        $this->adminRoutes();!!

        // for vendor route
        $this->vendorRoutes();
        // for staff route
        $this->staffRoutes();

        // for user route
        $this->userRoutes();
        $this->resellerRoute();

        // for ajax route
        $this->ajaxRoutes();

        $this->mapWebRoutes();


    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    // for admin route
    protected function adminRoutes()
    {
        Route::prefix('rstadminbd')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/adminRoutes.php'));
    }

    // for reseller route
    protected function resellerRoute()
    {

        Route::prefix('reseller')
        ->middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/resellerRoute.php'));


        // Route::prefix('reseller')
        //     ->middleware('web')
        //     ->namespace($this->namespace)
        //     ->group(base_path('routes/adminRoutes.php')); 
    }

    // for vendor route
    protected function vendorRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/vendorRoutes.php'));
    }

    // for staff route
    protected function staffRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/staffRoutes.php'));
    }

    // for customer route
    protected function userRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/userRoutes.php'));
    }

    // for ajax route
    protected function ajaxRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/ajaxRoutes.php'));
    }


}
