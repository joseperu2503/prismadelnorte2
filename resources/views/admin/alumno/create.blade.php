@extends('layouts.appAdmin')

@section('title','Nuevo Alumno')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   
    
@endsection
@section('content')
    <h1 class="titulo">Nuevo Alumno</h1>
    <div class="form-container">  
        <form action="/alumnos" method="POST">
            @csrf    
            <h3 class="text-center text-body">Datos del alumno</h3>
            <label class="form-label">DNI*</label>
            <input id="dni" name="dni" type="number" class="form-control mb-3" value="{{old('dni')}}" required>
            <label class="form-label">Apellido Paterno*</label>
            <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control mb-3" value="{{old('apellido_paterno')}}" required>
            <label class="form-label">Apellido Materno*</label>
            <input id="apellido_materno" name="apellido_materno" type="text" class="form-control mb-3" value="{{old('apellido_materno')}}" required>
            <label class="form-label">Primer nombre*</label>
            <input id="primer_nombre" name="primer_nombre" type="text" class="form-control mb-3" value="{{old('primer_nombre')}}" required>
            <label class="form-label">Segundo nombre</label>
            <input id="segundo_nombre" name="segundo_nombre" type="text" class="form-control mb-3" value="{{old('segundo_nombre')}}">
            <label class="form-label">Fecha de nacimiento*</label>
            <input type="date" name="fecha_nacimiento" class="form-control mb-3" value="{{old('fecha_nacimiento')}}" required>
            <label class="form-label">Departamento</label>
            <input id="departamento" name="departamento" type="text" class="form-control mb-3" value="{{old('departamento')}}">
            <label class="form-label">Provincia</label>
            <input id="provincia" name="provincia" type="text" class="form-control mb-3" value="{{old('provincia')}}">
            <label class="form-label">Distrito</label>
            <input id="distrito" name="distrito" type="text" class="form-control mb-3" value="{{old('distrito')}}">
            <label class="form-label">Religion</label>
            <input class="form-control mb-3" list="datalistOptions" id="exampleDataList" name="religion" value="{{old('religion')}}">
            <datalist id="datalistOptions">
                <option value="Católica">
            </datalist>
            <label class="form-label">Discapacidad</label>
            <input class="form-control mb-3" list="datalistOptions2" id="exampleDataList" name="discapacidad" value="{{old('discapacidad')}}">
            <datalist id="datalistOptions2">
                <option value="Ninguna">
            </datalist>
            <label class="form-label">Teléfono</label>
            <input id="telefono" name="telefono" type="number" class="form-control mb-3" value="{{old('telefono')}}">
            <input type="hidden" class="form-label" name="id_aula" value="{{$aula->id}}">
            <label class="form-label">Email</label>
            <input id="email" name="email" type="text" class="form-control mb-3" value="{{old('email')}}">
            <label class="form-label">Dirección</label>
            <input id="direccion" name="direccion" type="text" class="form-control mb-3" value="{{old('direccion')}}">
            <input type="hidden" class="form-label" name="foto_perfil" value="foto por defecto">
            <label class="form-label">Género*</label>       
            <select id="id_genero" name="id_genero" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($generos as $genero)
                    <option value="{{$genero->id}}">{{$genero->genero}}</option>
                @endforeach                                     
            </select>
            <label class="form-label">Grado*</label>       
            <select id="id_grado" name="id_grado" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($grados as $grado)
                    <option value="{{$grado->id}}">{{$grado->grado}}</option>
                @endforeach                                     
            </select>
            <label class="form-label">Contraseña*</label>
            <input id="password" name="password" type="text" class="form-control mb-3" value="{{old('password')}}" required>

            <h3 class="text-center text-body mt-5 mb-2">Datos del padre</h3>
            <label class="form-label">Nombres y apellidos</label>
            <input id="nombre_padre" name="nombre_padre" type="text" class="form-control mb-3" value="{{old('nombre_padre')}}">
            <label class="form-label">DNI</label>
            <input id="dni_padre" name="dni_padre" type="number" class="form-control mb-3" value="{{old('dni_padre')}}">
            <label class="form-label">Teléfono</label>
            <input id="telefono_padre" name="telefono_padre" type="number" class="form-control mb-3" value="{{old('telefono_padre')}}">

            <h3 class="text-center text-body mt-5 mb-2">Datos de la madre</h3>
            <label class="form-label">Nombres y apellidos</label>
            <input id="nombre_madre" name="nombre_madre" type="text" class="form-control mb-3" value="{{old('nombre_madre')}}">
            <label class="form-label">DNI</label>
            <input id="dni_madre" name="dni_madre" type="number" class="form-control mb-3" value="{{old('dni_madre')}}">
            <label class="form-label">Teléfono</label>
            <input id="telefono_madre" name="telefono_madre" type="number" class="form-control mb-3" value="{{old('telefono_madre')}}">

            <h3 class="text-center text-body mt-5 mb-2">Datos del apoderado</h3>
            <label class="form-label">Nombres y apellidos</label>
            <input id="nombre_apoderado" name="nombre_apoderado" type="text" class="form-control mb-3" value="{{old('nombre_apoderado')}}">
            <label class="form-label">DNI</label>
            <input id="dni_apoderado" name="dni_apoderado" type="number" class="form-control mb-3" value="{{old('dni_apoderado')}}">
            <label class="form-label">Teléfono</label>
            <input id="telefono_apoderado" name="telefono_apoderado" type="number" class="form-control mb-3" value="{{old('telefono_apoderado')}}">


            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        - {{ $error }} <br />
                    @endforeach
                </div>
            @endif
            <div class="buttons-form">
                <a href="/alumnos/{{$aula->id}}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>          
        </form>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection