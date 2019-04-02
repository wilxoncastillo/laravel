@extends('layout')

@section('title', "{$user->name}")

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ $user->name }}</h1>

        <p><a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-sm">Regresar al listado</a></p>
    </div>
    <div class="col-8">
	    @card
	        @slot('header','Detalle')
			<h5 class="card-title">ID del usuario: {{ $user->id }}</h5>
			<div class="card-text">
			<p><strong>Correo electrónico</strong>: {{ $user->email }}</p>
			<p><strong>Rol</strong>: {{ $user->role }}</p>
			<p><strong>Fecha de registro</strong>: {{ $user->created_at }}</p>
			</div>
	    @endcard
    </div>
    <div class="col-4">
	</div>
@endsection