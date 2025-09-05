@extends('layouts._partials.layout') 
@section('title', 'Información del estudio')
@section('subtitle')
    {{ __('Información del estudio') }}
@endsection
@section('content')
<h1>
    {{ $dicomFolderPath}}
</h1>
@endsection