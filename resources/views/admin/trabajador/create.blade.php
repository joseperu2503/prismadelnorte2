@extends('layouts.appAdmin')

@section('title','Nuevo Personal')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')
    <h1 class="titulo">Nuevo Personal</h1>
    <div class="form-container">  
        <form action="/trabajadores" method="POST">
            @csrf
            <label class="form-label">DNI</label>
            <input id="dni" name="dni" type="number" class="form-control mb-3" value="{{old('dni')}}">
            <label class="form-label">Apellido Paterno</label>
            <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control mb-3" value="{{old('apellido_paterno')}}">
            <label class="form-label">Apellido Materno</label>
            <input id="apellido_materno" name="apellido_materno" type="text" class="form-control mb-3" value="{{old('apellido_materno')}}">
            <label class="form-label">Primer Nombre</label>
            <input id="primer_nombre" name="primer_nombre" type="text" class="form-control mb-3" value="{{old('primer_nombre')}}"> 
            <label class="form-label">Segundo Nombre</label>
            <input id="segundo_nombre" name="segundo_nombre" type="text" class="form-control mb-3" value="{{old('segundo_nombre')}}">          
            <label class="form-label">Telefono</label>
            <input id="telefono" name="telefono" type="number" class="form-control mb-3" value="{{old('telefono')}}">
            <label class="form-label">Dirección</label>
            <input id="direccion" name="direccion" type="text" class="form-control mb-3" value="{{old('direccion')}}">
            <label class="form-label">Puesto</label>
            <input id="puesto" name="puesto" type="text" class="form-control mb-3" value="{{old('puesto')}}">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        - {{ $error }} <br />
                    @endforeach
                </div>
            @endif
            <div class="buttons-form">
                <a href="/trabajadores" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>          
        </form>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection