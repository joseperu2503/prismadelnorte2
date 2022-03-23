@extends('layouts.appAdmin')

@section('title','Asistencia')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

@endsection

@section('content')
<h1 class = "titulo">Asistencia</h1>		
<h2 class="fecha">{{$fecha}}</h2>
<button id="btn-abrir-popup-nuevo" class="btn btn-success">Cambiar de camara</button>

<div class="mt-3 alert" role="alert" id="mensaje" style="display: none"></div>
    
<div class="camara-grid">
    <video id="preview" width="100%" class="video"></video>
    <form id="form" method="POST" class="form">
        @csrf
        <label class="form-label">DNI del alumno</label>
        <input type="text" name="text" id="text" readonny="" placeholder="Código escaneado" class="form-control">
        <button type="button"  class="btn btn-success mt-3" style="width: max-content" id="registrar">Registrar</button>
    </form>               
</div>
<h2 class = "titulo-2">Asistencias recien registradas </h2>
<div class="table-responsive p-1">
    <table class = "table">
        <thead>
            <tr>
                <th scope="col">Apellidos y nombres</th>
                <th scope="col">Rol</th>
                <th scope="col">Hora</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody id="ultimos-registros">
            @include('admin.asistencia.ultimos_registros') 
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