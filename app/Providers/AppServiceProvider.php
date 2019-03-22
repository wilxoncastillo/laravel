<?php

namespace App\Providers;

use App\Http\ViewComposer\UserFieldsComposer;
use App\Profession;
use App\Skill;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('shared._card', 'card');

        /*
        view()->composer(['users.create', 'users.edit'], function ($view) {
            $professions = Profession::orderBy('title', 'asc')->get();
            $skills = Skill::orderBy('name', 'asc')->get();
            $roles = trans('users.roles');

            $view->with(compact('professions','skills', 'roles'));
        });
        */

        view()->composer(['users.create', 'users.edit'], UserFieldsComposer::class) ;
        //view()->composer('users/_fields', UserFieldsComposer::class) ;

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
