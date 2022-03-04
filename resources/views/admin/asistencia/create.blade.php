@extends('layouts.appAdmin')

@section('title','Asistencia')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
@endsection

@section('content')
<h1 class = "titulo">Asistencia</h1>		
<h2 class="fecha">{{$fecha}}</h2>
<button id="btn-abrir-popup-nuevo" class="btn btn-success">Cambiar de camara</button>
@if (session('success'))
    <div class="alert alert-success mt-3" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger mt-3" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="camara-grid">
    <video id="preview" width="100%" class="video"></video>
    <form action="/agregando_asistencia" method="POST" class="form">
        @csrf
        @method('PUT')
        <label>ID del alumno</label>
        <input type="text" name="text" id="text" readonny="" placeholder="Código escaneado" class="form-control">
    </form>               
</div>
<h2 class = "titulo-2">Asistencias recien registradas </h2>
<div class="table-responsive">
    <table class = "table">
        <thead>
            <tr>
                <th scope="col">Apellidos y nombres</th>
                <th scope="col">Rol</th>
                <th scope="col">Hora</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asistencias as $asistencia)
                <tr>
                    <td class="align-middle">{{$asistencia->apellido_paterno}} {{$asistencia->apellido_materno}} {{$asistencia->primer_nombre}} {{$asistencia->segundo_nombre}}</td>
                    <td class="align-middle">{{$asistencia->role}}</td>
                    <td class="align-middle">{{$asistencia->created_at->format('H:i:s')}}</td>
                    <td class="align-middle">{{$asistencia->estado}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="{{asset('js/asistencia.js')}}"></script>
@endsection