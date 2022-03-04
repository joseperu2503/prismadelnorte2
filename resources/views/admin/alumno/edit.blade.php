@extends('layouts.appAdmin')

@section('title','Editar Alumno')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')
<h1 class="titulo">Editar Alumno</h1>

<div class="form-container">  
    @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    - {{ $error }} <br />
                @endforeach
            </div>
        @endif
    <form action="/alumnos/{{$alumno->id}}" method="POST">
        @csrf
        @method('PUT')
        <h3 class="text-center text-body">Datos del alumno</h3>
        <label class="form-label">DNI*</label>
        <input id="dni" name="dni" type="number" class="form-control mb-3" value="{{$alumno->dni}}">
        <label class="form-label">Apellido Paterno*</label>
        <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control mb-3" value="{{$alumno->apellido_paterno}}">
        <label class="form-label">Apellido Materno*</label>
        <input id="apellido_materno" name="apellido_materno" type="text" class="form-control mb-3" value="{{$alumno->apellido_materno}}">
        <label class="form-label">Primer nombre*</label>
        <input id="primer_nombre" name="primer_nombre" type="text" class="form-control mb-3" value="{{$alumno->primer_nombre}}">
        <label class="form-label">Segundo nombre</label>
        <input id="segundo_nombre" name="segundo_nombre" type="text" class="form-control mb-3" value="{{$alumno->segundo_nombre}}">
        <label class="form-label">Fecha de nacimiento*</label>
        <input type="date" name="fecha_nacimiento" class="form-control mb-3" value="{{$alumno->fecha_nacimiento}}" required>
        <label class="form-label">Departamento</label>
        <input id="departamento" name="departamento" type="text" class="form-control mb-3" value="{{$alumno->departamento}}">
        <label class="form-label">Provincia</label>
        <input id="provincia" name="provincia" type="text" class="form-control mb-3" value="{{$alumno->provincia}}">
        <label class="form-label">Distrito</label>
        <input id="distrito" name="distrito" type="text" class="form-control mb-3" value="{{$alumno->distrito}}">
        <label class="form-label">Religion</label>
        <input class="form-control mb-3" list="datalistOptions" id="exampleDataList" name="religion" value="{{$alumno->religion}}">
        <datalist id="datalistOptions">
            <option value="Católica">
        </datalist>
        <label class="form-label">Discapacidad</label>
            <input class="form-control mb-3" list="datalistOptions2" id="exampleDataList" name="discapacidad" value="{{$alumno->discapacidad}}">
            <datalist id="datalistOptions2">
                <option value="Ninguna">
            </datalist>
        <label class="form-label">Telefono</label>
        <input id="telefono" name="telefono" type="number" class="form-control mb-3" value="{{$alumno->telefono}}">
        <label class="form-label">Email</label>
        <input id="email" name="email" type="text" class="form-control mb-3" value="{{$alumno->email}}">
        <label class="form-label">Dirección</label>
        <input id="direccion" name="direccion" type="text" class="form-control mb-3" value="{{$alumno->direccion}}">
        <label class="form-label">Genero</label>
        <select id="id_genero" name="id_genero" class="form-select mb-3" required>
            <option selected disabled value="">Seleccione una opción</option>
            @foreach ($generos as $genero)
                @if ($genero->id==$alumno->id_genero)
                    <option selected value="{{$genero->id}}">{{$genero->genero}}</option>   
                @else
                    <option value="{{$genero->id}}">{{$genero->genero}}</option>   
                @endif            
            @endforeach                                     
        </select>
        <label class="form-label">Grado</label>
        <select id="id_grado" name="id_grado" class="form-select mb-3" required>
            <option selected disabled value="">Seleccione una opción</option>
            @foreach ($grados as $grado)
                @if ($grado->id==$alumno->id_grado)
                    <option selected value="{{$grado->id}}">{{$grado->grado}}</option>   
                @else
                    <option value="{{$grado->id}}">{{$grado->grado}}</option>   
                @endif            
            @endforeach                                     
        </select>
        <label class="form-label">Aula*</label>
        <select id="id_aula" name="id_aula" class="form-select mb-3" required>
            <option selected disabled value="">Seleccione una opción</option>
            @foreach ($aulas as $aula)
                @if ($aula->id==$alumno->id_aula)
                    <option selected value="{{$aula->id}}">{{$aula->aula}}</option>   
                @else
                    <option value="{{$aula->id}}">{{$aula->aula}}</option>   
                @endif            
            @endforeach                                     
        </select>
        <label class="form-label">Contraseña</label>
        <input id="password" name="password" type="text" class="form-control mb-3">  

        <h3 class="text-center text-body mt-5 mb-2">Datos del padre</h3>
        <label class="form-label">Nombres y apellidos</label>
        <input id="nombre_padre" name="nombre_padre" type="text" class="form-control mb-3" value="{{$alumno->nombre_padre}}">
        <label class="form-label">DNI</label>
        <input id="dni_padre" name="dni_padre" type="number" class="form-control mb-3" value="{{$alumno->dni_padre}}">
        <label class="form-label">Teléfono</label>
        <input id="telefono_padre" name="telefono_padre" type="number" class="form-control mb-3" value="{{$alumno->telefono_padre}}">

        <h3 class="text-center text-body mt-5 mb-2">Datos de la madre</h3>
        <label class="form-label">Nombres y apellidos</label>
        <input id="nombre_madre" name="nombre_madre" type="text" class="form-control mb-3" value="{{$alumno->nombre_madre}}">
        <label class="form-label">DNI</label>
        <input id="dni_madre" name="dni_madre" type="number" class="form-control mb-3" value="{{$alumno->dni_madre}}">
        <label class="form-label">Teléfono</label>
        <input id="telefono_madre" name="telefono_madre" type="number" class="form-control mb-3" value="{{$alumno->telefono_madre}}">

        <h3 class="text-center text-body mt-5 mb-2">Datos del apoderado</h3>
        <label class="form-label">Nombres y apellidos</label>
        <input id="nombre_apoderado" name="nombre_apoderado" type="text" class="form-control mb-3" value="{{$alumno->nombre_apoderado}}">
        <label class="form-label">DNI</label>
        <input id="dni_apoderado" name="dni_apoderado" type="number" class="form-control mb-3" value="{{$alumno->dni_apoderado}}">
        <label class="form-label">Teléfono</label>
        <input id="telefono_apoderado" name="telefono_apoderado" type="number" class="form-control mb-3" value="{{$alumno->telefono_apoderado}}">
        
        <div class="buttons-form">
            <a href="/alumnos/{{$alumno->id_aula}}" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-success" >Actualizar</button>
        </div>          
    </form>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection