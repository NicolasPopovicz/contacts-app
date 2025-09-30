<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends RouteServiceProvider
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
        // parent::boot();

        // // Adiciona aqui a carga do arquivo de rotas customizado
        // Route::prefix('api')
        //     ->middleware('api')
        //     ->group(base_path('app/Routes/api.php'));
    }
}
