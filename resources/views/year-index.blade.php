@extends('layouts.app')

@section('title',"Páginas de estadísticas ({$period})")

@section('content')
    <h1>Páginas de estadísticas ({{ $period }})</h1>
    @foreach ($routes as $route)
        <a href="{{ route($route['name']) }}">{{ $route['uri'] }}</a>
        <br>
    @endforeach
@endsection