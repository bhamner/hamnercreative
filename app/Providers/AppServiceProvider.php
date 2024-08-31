<?php

namespace App\Providers;

use App;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        if ( App::environment('production') ) {
            $urlGenerator->forceScheme("https");
        }

        Gate::define('admin', function ( \App\Models\User $user ) {
            return $user->clients->count() > 1;
        });

        Gate::define('user_has_client', function ( \App\Models\User $user,  $request ) {
            return ( !$request->has('client') || $request->has('client') && Auth::check() &&  Auth::user()->clients->contains( $request->client ) );
        });

    }
}
