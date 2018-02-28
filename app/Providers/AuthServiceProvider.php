<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('edit-notes', function ($user, $noteId) {
            if($user->notes()->where('id', $noteId)->exists()) {
                return true;
            }
            foreach($user->roles as $role) {
                if($role->permissions->pluck('name')->contains('can-edit-notes')) {
                    return true;
                }
            }
            return false;
        });

        $gate->define('delete-notes', function ($user, $noteId) {
            if($user->notes()->where('id', $noteId)->exists()) {
                return true;
            }
            foreach($user->roles as $role) {
                if($role->permissions->pluck('name')->contains('can-delete-notes')) {
                    return true;
                }
            }
            return false;
        });

        $gate->define('make-modes', function ($user, $userId) {
            if($user->id == $userId) {
                return false;
            }
            foreach($user->roles as $role) {
                if($role->permissions->pluck('name')->contains('can-make-modes')) {
                    return true;
                }
            }
            return false;
        });

        $gate->define('delete-users', function ($user, $userId) {
            if($user->id == $userId) {
                return false;
            }
            foreach($user->roles as $role) {
                if($role->permissions->pluck('name')->contains('can-delete-users')) {
                    return true;
                }
            }
            return false;
        });
    }
}
