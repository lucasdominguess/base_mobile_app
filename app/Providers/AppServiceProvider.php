<?php

namespace App\Providers;


use App\Console\Commands\CleanAll;
use App\Enums\UserRoles;
use App\Interfaces\LdapInterface;
use App\Interfaces\PdfExporterInterface;
use App\Interfaces\SanitizerInterface;
use App\Interfaces\SocialAuthInterface;
use App\Services\DomPdfService;
use App\Services\GoogleAuthService;
use App\Services\LdapService;
use App\Services\XssCleanService;
use App\Users\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
             if ($this->app->runningInConsole()) {
            $this->commands([
                CleanAll::class,
            ]);
        }

        $this->app->bind(SanitizerInterface::class, XssCleanService::class);
        $this->app->bind(LdapInterface::class, LdapService::class);
        $this->app->bind(PdfExporterInterface::class, DomPdfService::class);


        // $this->app->bind(SocialAuthInterface::class, GoogleAuthService::class);
        // $this->app->register(L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'testing') {
            Artisan::call('migrate', ['--force' => true]);
        }

        Route::pattern('id', '[0-9]+');
        // Gate para verificar se o usuário é um Administrador
        Gate::define('Is-admin', function ($user) {
            return $user->role === UserRoles::ADMIN;
        });
    }
}
