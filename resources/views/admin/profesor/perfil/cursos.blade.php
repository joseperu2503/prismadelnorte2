@extends('layouts.appProfesor')

@section('title','Cursos')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')

    <h1 class="titulo">Cursos</h1>

    <div class="table-responsive">
        <table class = "table table-hover">
            <thead>
                <tr>                    
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Aula</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr>
                        <td class="align-middle">{{$curso->codigo}}</td>
                        <td class="align-middle">{{$curso->nombre}}</td>
                        <td class="align-middle">{{$curso->aula->aula}}</td>
                        <td><a href="/curso/{{$curso->id}}" class="btn btn-success">Entrar</a></td>
                    </tr>      
                @endforeach        
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection