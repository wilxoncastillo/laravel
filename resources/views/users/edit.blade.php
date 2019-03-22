@extends('layout')
@section('title', "Editar Usuario")
@section('content')
    <div class="card">
        <h4 class="card-header">Editar Usuario</h4>
        <div class="card-body">

            @include('shared._errors')

            <form method="POST" action="{{ url("users/{$user->id}") }}">
                {{ method_field('PUT') }}

                @include('shared._fields')
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>
            </form>
        </div>
    </div>
@endsection