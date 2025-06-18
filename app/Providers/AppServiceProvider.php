<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Model\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Models\Sanctum\PersonalAccessToken;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('bearer')
                );
            });
        // Route::aliasMiddleware('check.admin', CheckAdminRole::class);
    }
}
