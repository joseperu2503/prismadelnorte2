@extends('layouts.appAlumno')

@section('title','Cursos')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')

    <h1 class="titulo">Mis cursos</h1>

    <div class = "cursos-grid">
        @foreach ($cursos as $curso)      
            <a href="/alumno/cursos/{{$curso->codigo}}">
                <article class = "curso">
                    <h2 class="text-capitalize">{{$curso->nombre}}</h2>
                </article>
            </a>				
        @endforeach
    </div>
@endsection