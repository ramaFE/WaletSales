<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\CreatesNewUsers; // Tambahkan ini
use Laravel\Fortify\Contracts\RegisterViewResponse; // Tambahkan ini
use Laravel\Fortify\Contracts\LoginViewResponse; // Tambahkan ini
use Laravel\Fortify\Http\Responses\SimpleViewResponse; // Tambahkan ini

class FortifyServiceProvider extends ServiceProvider
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
        // Binding kontrak CreatesNewUsers ke implementasi CreateNewUser
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

        // Binding kontrak RegisterViewResponse ke implementasi SimpleViewResponse
        $this->app->singleton(RegisterViewResponse::class, function () {
            return new SimpleViewResponse('auth.register');
        });

        // Binding kontrak LoginViewResponse ke implementasi SimpleViewResponse
        $this->app->singleton(LoginViewResponse::class, function () {
            return new SimpleViewResponse('auth.login');
        });

        // Action untuk Fortify
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate Limiter
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        // View untuk register
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // View untuk login
        Fortify::loginView(function () {
            return view('auth.login');
        });
    }
}
