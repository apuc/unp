<?php

namespace App\Providers;

use URI;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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

        $this->mapWebAuthRoutes();
        $this->mapWebSiteRoutes();
        $this->mapWebAccountRoutes();
        $this->mapWebOfficeRoutes();
        $this->mapWebServiceRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    // Сервисные маршруты
    protected function mapWebServiceRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web-service.php'));
    }

    // Авторизация
    protected function mapWebAuthRoutes()
    {
        Route::middleware(['web', 'site.counters', 'site.menu', 'site.socials', 'site.texts', 'site.forecasts'])
             ->namespace($this->namespace)
			 ->domain(URI::projectHost())
             ->group(base_path('routes/web-auth.php'));
    }

    // Сайт
    protected function mapWebSiteRoutes()
    {
        Route::middleware(['web', 'site.counters', 'site.menu', 'site.socials', 'site.texts', 'site.forecasts'])
			 ->domain(URI::projectHost())
			 ->name('site.')
			 ->namespace($this->namespace . '\\Site')
             ->group(base_path('routes/web-site.php'));
    }

    // Личный кабинет пользователя
    protected function mapWebAccountRoutes()
    {
        Route::middleware(['web', 'auth', 'site.counters', 'site.menu', 'site.socials', 'site.texts', 'site.forecasts'])
			->domain(URI::projectHost())
            ->name('account.')
  			->namespace($this->namespace . '\\Account')
            ->prefix('account')
            ->group(base_path('routes/web-account.php'));
    }

    // Панель управления
    protected function mapWebOfficeRoutes()
    {
        Route::middleware(['web', 'auth', 'can:admin'])
 			->domain(URI::projectHost())
 			->name('office.')
            ->prefix('admin')
 			->namespace($this->namespace . '\\Office')
            ->group(base_path('routes/web-office.php'));
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
}
