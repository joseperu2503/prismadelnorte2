@extends('layouts.appAlumno')

@section('title','Perfil')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')

<h1 class = "titulo">Perfil</h1>

<div class="row">
    <div class="col-12 mx-auto" style="max-width: 900px">
        <div class="card rounded-3 bg-light bg-gradient py-4 px-3 text-secondary">
            <div class="perfil-encabezado">
                <img src="{{$alumno->foto_perfil}}" class="perfil-imagen" style="max-width: 180px">
                <button title="Cambiar foto" class = "camera" id="btn-abrir-popup-nuevo">
                    <i class="fas fa-camera "></i>
                </button>
                <div class="perfil-encabezado-nombre">
                    <h2 class="fw-bold fs-1 text-secondary m-0">{{$alumno->primer_nombre}} {{$alumno->apellido_paterno}}</h2>
                    <p class="fs-6 fw-light text-secondary mb-0">{{$aula->aula}}</p>
                </div>
            </div>
            <div class="row border-bottom mb-3 mt-4">
                <div class="col">
                    <h5 class="fs-6 mb-1 fw-bold">DATOS GENERALES</h5>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">DNI:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->dni}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Apellido paterno:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->apellido_paterno}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Apellido materno:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->apellido_materno}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Primer nombre:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->primer_nombre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            
            @if ($alumno->segundo_nombre != null)
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Segundo nombre:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->segundo_nombre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            @endif
            @if ($alumno->fecha_nacimiento != null)
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Fecha de nacimiento:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{date('d-m-Y', strtotime($alumno->fecha_nacimiento))}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            @endif
            @if ($alumno->direccion != null)
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Dirección:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->direccion}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Telefono:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->telefono}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">E-mail:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->email}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            @endif
            <div class="row border-bottom mb-3 mt-4">
                <div class="col">
                    <h5 class="fs-6 mb-1 fw-bold">LUGAR DE NACIMIENTO DEL ALUMNO</h5>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Departamento:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->departamento}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Provincia:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->provincia}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Distrito:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->distrito}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>

            <div class="row border-bottom mb-3 mt-4">
                <div class="col">
                    <h5 class="fs-6 mb-1 fw-bold">DATOS DEL PADRE</h5>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">DNI:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->dni_padre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Nombres y apellidos:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->nombre_padre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Telefono:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->telefono_padre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>

            <div class="row border-bottom mb-3 mt-4">
                <div class="col">
                    <h5 class="fs-6 mb-1 fw-bold">DATOS DE LA MADRE</h5>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">DNI:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->dni_madre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Nombres y apellidos:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->nombre_madre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Telefono:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->telefono_madre}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>

            <div class="row border-bottom mb-3 mt-4">
                <div class="col">
                    <h5 class="fs-6 mb-1 fw-bold">DATOS DEL APODERADO</h5>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">DNI:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->dni_apoderado}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Nombres y apellidos:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->nombre_apoderado}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-auto col-sm-3 d-flex align-items-center">Telefono:</label>
                <div class="col-12 col-sm-9">
                    <input class="form-control form-control-sm" type="text" value="{{$alumno->telefono_apoderado}}" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>


            
    
        </div>       
    </div>
</div>

<div class="overlay-nuevo" id="overlay-nuevo">
    <div class="popup-nuevo" id="popup-nuevo">
        <div class = "popup-header-nuevo">                  
            <h3 class = "popup-titulo-nuevo">Actualizar foto de perfil</h3>
            <a href="#" id="btn-cerrar-popup-nuevo" class="btn-cerrar-popup-nuevo"><i class="fas fa-times"></i></a>
        </div>

        <div class="imagen">
            <img src="{{$alumno->foto_perfil}}" width="200px" id="imagenSeleccionada">
        </div>  
        <form  id="upload_image" action="/alumno/{{$alumno->id}}/actualizar_foto" class="form-horizontal" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label class="seleccione_imagen">
                <i class="fas fa-image"></i>
                <p>Seleccione la imagen</p>
                <input id="imagen" type="file" name="foto_perfil" class="hidden" >
            </label>

            <button type="submit" name="submit" class="hecho">Hecho</button>
            </div>
        </form>				
    </div>
</div>

<script>
    var btnAbrirPopup_nuevo = document.getElementById('btn-abrir-popup-nuevo'),
	overlay_nuevo = document.getElementById('overlay-nuevo'),
	popup_nuevo = document.getElementById('popup-nuevo'),
	btnCerrarPopup_nuevo = document.getElementById('btn-cerrar-popup-nuevo');


    btnAbrirPopup_nuevo.addEventListener('click', function(){
        overlay_nuevo.classList.add('active');
        popup_nuevo.classList.add('active');
    });

    btnCerrarPopup_nuevo.addEventListener('click', function(e){
        e.preventDefault();
        overlay_nuevo.classList.remove('active');
        popup_nuevo.classList.remove('active');
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
<script>   
    $(document).ready(function (e) {   
        $('#imagen').change(function(){            
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#imagenSeleccionada').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    });
</script>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection