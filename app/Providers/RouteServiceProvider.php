<?php

namespace App\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */


    public function boot(): void
    {
        // Daftarkan alias middleware 'check.admin'
        Route::aliasMiddleware('check.admin', \App\Http\Middleware\CheckAdminRole::class);
        Route::aliasMiddleware('check.status.account', \App\Http\Middleware\CheckActiveStatus::class);

        // Definisikan route group
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
