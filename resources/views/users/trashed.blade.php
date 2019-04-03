
@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h2 class="pb-1">{{ $title }}</h2>
    </div>

    @if ($users->isNotEmpty())
    <table class="table">
        <thead class="thead-dark table-sm">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Borrado</th>
            <th scope="col" width="120px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->deleted_at }}</td>
            <td>
            <form action="{{ route('users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{ route('users.restore', $user) }}" class="btn btn-link"><span class="oi oi-action-undo"></span></a>


                <button type="submit" class="btn btn-link"><span class="oi oi-delete"></span></button>
            </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->render() }}
    @else
        <p>No hay usuarios registrados en papelera.</p>
    @endif
@endsection

@section('sidebar')
    @parent
@endsection