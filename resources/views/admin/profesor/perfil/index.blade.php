@extends('layouts.appProfesor')

@section('title','Home')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')
<h1 class="titulo">Inicio</h1>
<div class="container">
    <div class="row">
        @foreach ($posts as $post)
            @if ($post->user->dni == $profesor->dni || ($post->user->role == 'admin' && (@$post->curso->id_profesor == $profesor->id || is_null($post->id_curso))))
                <x-post :post="$post"/>   
            @endif         
        @endforeach
    </div>  
</div>
@endsection
@section('js')
    <script src="{{asset('js/sweetAlert.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection