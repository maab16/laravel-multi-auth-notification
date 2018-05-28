<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
         * Resolving Multi Guard Isuue for Broadcasting
         * Big Thanks Kağan KAHRAMAN(https://github.com/ArcadiaS) for his comment on https://github.com/tlaverdure/laravel-echo-server/issues/81
         */

        Auth::resolveUsersUsing(function ($guard = null) {
            if( is_null($guard) ){
                $guards = array_keys(config('auth.guards'));
                foreach ($guards as $guard) {
                    if(Auth::guard($guard)->check()){
                        return Auth::guard($guard)->user();
                    }
                }
            }
            return Auth::guard($guard)->user();
        });
    }
}
