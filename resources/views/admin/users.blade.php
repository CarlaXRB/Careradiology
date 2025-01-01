@extends('layouts._partials.layout')
@section('title','Users')
@section('subtitle')
    {{ __('Usuarios') }}
@endsection
@section('content')
<div class="flex justify-end"><a href="{{route('admin.create')}}" class="botton1">Crear Usuario</a> </div>
<h1 class="txt-title1">USUARIOS</h1>
<div class="grid grid-cols-5 gap-4 border-b border-cyan-500 mb-3">
    <h3 class="txt-head">Nombre de usuario</h3>
    <h3 class="txt-head">Correo</h3>
    <h3 class="txt-head">Rol</h3>
</div>
<ul>
    @forelse($users as $user)
    <div class="grid grid-cols-5 border-b border-gray-600 gap-4 mb-3 text-white pl-6">
        <p>{{ $user->name }}</p>
        <p>{{ $user->email }}</p>
        <p>{{ $user->role }}</p>
    <form method="POST" action="{{ route('admin.destroy', $user->id) }}">
        @csrf
        @method('DELETE')
        <div class="flex justify-end"><input type="submit" value="Eliminar" class="botton2"/></div>
    </form>
    </div>
    @empty
    <p>No data</p>
    @endforelse
    {{ $users->links()}}
</ul>
@endsection