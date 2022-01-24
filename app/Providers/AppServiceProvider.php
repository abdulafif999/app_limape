<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function(User $user, $ability){
            if($user->checkRole('admin')){
                return true;
            }
        });
  
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });
    }
}
