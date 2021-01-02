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
    public const HOME = '/home';

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

        $this->mapWebRoutes();

        $this->mapManagerRoutes();
        $this->mapAccountantRoutes();
        $this->mapClientRoutes();
    }

    /**
     * Define the "manager" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapManagerRoutes()
    {
        Route::group([
            'middleware' => ['web', 'manager', 'auth:manager'],
            'prefix' => 'manager',
            'as' => 'manager.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/manager.php');
        });
    }


    protected function mapAccountantRoutes()
    {
        Route::group([
            'middleware' => ['web', 'accountant', 'auth:accountant'],
            'prefix' => 'accountant',
            'as' => 'accountant.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/accountant.php');
        });
    }


    protected function mapClientRoutes()
    {
        Route::group([
            'middleware' => ['web', 'client', 'auth:client'],
            'prefix' => 'client',
            'as' => 'client.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/client.php');
        });
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


}
