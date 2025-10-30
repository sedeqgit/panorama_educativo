@extends('layouts.app')

@section('title',"Páginas de estadísticas ({$period})")

@section('content')
    <h1>Páginas de estadísticas ({{ $period }})</h1>
    @foreach ($routes as $route)
        <a href="/{{ $route['uri'] }}">{{ $route['uri'] }}</a>
        <br>
    @endforeach
@endsection