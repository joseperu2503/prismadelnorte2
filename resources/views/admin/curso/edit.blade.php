@extends('layouts.appAdmin')

@section('title','Editar Curso')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')
    <h1 class="titulo">Editar Curso</h1>
    <div class="form-container">  
        <form action="/cursos/{{$curso->id}}" method="POST">
            @csrf
            @method('PUT')
            <label class="form-label">Código*</label>
            <input id="codigo" name="codigo" type="text" class="form-control" value="{{$curso->codigo}}">
            <div id="emailHelp" class="form-text mb-3">Usar solo mayusculas y números.</div>
            <label class="form-label">Nombre*</label>
            <input id="nombre" name="nombre" type="text" class="form-control" value="{{$curso->nombre}}">
            <div id="emailHelp" class="form-text mb-3">Usar mayusculas y minusculas.</div>
            <label class="form-label">Aula*</label>

            <select name="id_aula" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($aulas as $aula)                       
                    @if ($curso->id_aula == $aula->id)
                        <option selected value="{{$aula->id}}">{{$aula->aula}}</option>
                    @else
                        <option value="{{$aula->id}}">{{$aula->aula}}</option>
                    @endif                      
                @endforeach                                     
            </select>

            <label class="form-label">Profesor*</label>

            <select name="id_profesor" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($profesores as $profesor)                       
                    @if ($curso->id_profesor == $profesor->id)
                        <option selected value="{{$profesor->id}}">{{$profesor->primer_nombre}} {{$profesor->apellido_paterno}}</option>
                    @else
                        <option value="{{$profesor->id}}">{{$profesor->primer_nombre}} {{$profesor->apellido_paterno}}</option>
                    @endif                      
                @endforeach                                     
            </select>
      
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        - {{ $error }} <br />
                    @endforeach
                </div>
            @endif
            <div class="buttons-form">
                <a href="/cursos" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>          
        </form>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection