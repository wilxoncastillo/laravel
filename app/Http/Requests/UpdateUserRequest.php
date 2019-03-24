<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


//add
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
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
        ];

        
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'email.email' => 'Por favor ingresa una dirección valida',
            'email.unique' => 'Ya existe un usuario con ese Email',
        ];
    }

     public function updateUser(User $user)
     {
        $data = $this->validated();

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->profile->update($data);
        $user->skills()->sync($data['skills'] ?? []);
     }
}
