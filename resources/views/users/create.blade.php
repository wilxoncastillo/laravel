@extends('layout')

@section('title', "Crear usuario")

@section('content')
    <div class="card">
        <h4 class="card-header">Crear usuario</h4>
        <div class="card-body">
            
            @include('shared._errors')
            
            <form method="POST" action="{{ url('users') }}">
                
                @include('shared._fields')
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>
            </form>
        </div>
    </div>
@endsection