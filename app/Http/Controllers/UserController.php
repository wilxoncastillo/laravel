<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// add
use App\{
    Http\Requests\CreateUserRequest, Profession, Skill, User, UserProfile
};

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
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* pasando por el AppServiceProvider
        $professions = \App\Profession::orderBy('title', 'asc')->get();
        $skills = \App\Skill::orderBy('name', 'asc')->get();
        $roles = trans('users.roles');
        return  view('users.edit', compact('user','professions','skills', 'roles'));
        */
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
        /* pasando por el AppServiceProvider
        $professions = \App\Profession::orderBy('title', 'asc')->get();
        $skills = \App\Skill::orderBy('name', 'asc')->get();
        $roles = trans('users.roles');
        return  view('users.edit', compact('user','professions','skills', 'roles'));
        */

        return  view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => '',
            'bio' => 'required',
            'role' => ['nullable', Rule::in(Role::getList())],
            'twitter' => ['nullable', 'present', 'url'],
            'profession_id' => [
                'nullable', 'present',
                Rule::exists('professions', 'id')->whereNull('deleted_at')
            ],
            'skills' => [
                'array',
                Rule::exists('skills', 'id'),
            ],
        ], [
            'name.required' => 'El campo nombre es requerido',
            'email.email' => 'Por favor ingresa una dirección valida',
            'email.unique' => 'Ya existe un usuario con ese email',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->profile->update($data);
        $user->skills()->attach($data['skills'] ?? []);
        return redirect()->route('users.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
