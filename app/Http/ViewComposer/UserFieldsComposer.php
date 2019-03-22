<?php

// add
namespace App\Http\ViewComposer;
use App\Profession;
use App\Skill;
use Illuminate\Contracts\View\View;

class UserFieldsComposer
{
    public function compose(View $view)
    {
        $professions = Profession::orderBy('title', 'asc')->get();
        $skills = Skill::orderBy('name', 'asc')->get();
        $roles = trans('users.roles');

        $view->with(compact('professions','skills', 'roles'));
    }
}
