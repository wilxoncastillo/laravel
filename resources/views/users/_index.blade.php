@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h2 class="pb-1">{{ $title }}</h2>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
            <a href="{{ route('users.trashed') }}" class="btn btn-primary"><span class="oi oi-trash"></a>
        </p>
    </div>

    @if ($users->isNotEmpty())
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Profesion</th>
            <th scope="col" width="160px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->profile->profession->title }}</td>
            <td>
                @if ($user->trashed())
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
                    </form>
                @else
                    <form action="{{ route('users.trash', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <a href="{{ route('users.show', $user) }}" class="btn btn-link"><span class="oi oi-eye"></span></a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-link"><span class="oi oi-pencil"></span></a>
                        <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->render() }}
    @else
        <p>No hay usuarios registrados.</p>
    @endif
@endsection

@section('sidebar')
    @parent
@endsection