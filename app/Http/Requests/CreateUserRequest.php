<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//add
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
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
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'last_name.required' => 'El campo nombre es obligatorio',
            'email.email' => 'Por favor ingresa una dirección valida',
            'email.unique' => 'Ya existe un usuario con ese Email',
        ];
    }


    public function createUser()
    {
        DB::transaction(function () {
            $data = $this->validated();
            
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'] ?? 'user',
            ]);


            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'],
                'profession_id' => $data['profession_id'],
            ]);

            $user->skills()->attach($data['skills'] ?? []);
        });
    }
}
