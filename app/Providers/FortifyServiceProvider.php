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
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Http\Responses\SimpleViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tambahkan binding untuk RegisterViewResponse dan LoginViewResponse
        $this->app->singleton(RegisterViewResponse::class, function () {
            return new SimpleViewResponse('auth.register');
        });

        $this->app->singleton(LoginViewResponse::class, function () {
            return new SimpleViewResponse('auth.login');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set action untuk pembuatan user baru, update password, dsb.
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate limiter untuk login
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate limiter untuk two-factor
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Register view untuk halaman register
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Register view untuk halaman login
        Fortify::loginView(function () {
            return view('auth.login');
        });
    }
}
