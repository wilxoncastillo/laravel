<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// add
use App\{Profession, Skill, User, UserProfile};
use App\Http\Requests\{CreateUserRequest, UpdateUserRequest};

use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()
        ->byState(request('state'))
        ->byRole(request('role'))
        ->search(request('search'))
        ->orderByDesc('created_at')
        ->paginate();

        $users->appends(request(['search']));

        $users->load('team', 'profile.profession', 'skills');


        return view('users.index', [
            'users' => $users,
            'title' => 'Listado de usuarios',
            'roles' => trans('users.filters.roles'),
            'skills' => Skill::orderBy('name')->get(),
            'states' => trans('users.filters.states'),
            'checkedSkills' => collect(request('skills')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return  view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(CreateUserRequest $request)
    {
        $request->createUser();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return  view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    //public function update(User $user)
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);
        return redirect()->route('users.show', ['user' => $user]);
    }


    public function trash(User $user)
    {
        $user->delete();
        $user->profile()->delete();
        $user->skills()->detach();
        return redirect()->route('users.index');
    }


    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();
        $user->restore();
        $user->profile()->restore();
        return redirect()->route('users.trashed');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate();

        $title = 'Listado de usuarios en papelera';
        return view('users.trashed', compact('title', 'users'));
        //return view('users.index', compact('title', 'users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();
        $user->forceDelete();
        return redirect()->route('users.trashed');
    }
}
