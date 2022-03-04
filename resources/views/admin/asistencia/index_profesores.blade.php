@extends('layouts.appAdmin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
@endsection

@section('title','Asistencia de profesores')

@section('content')
<h1 class = "titulo">Asistencia de profesores</h1>
<div class="table-responsive">
    <table id="table_id" class = "table table-hover">
        <thead>
            <tr>
                <th scope="col">DNI</th>
                <th scope="col">Apellido Paterno</th>
                <th scope="col">Apellido Materno</th>
                <th scope="col">Primer Nombre</th>
                <th scope="col">Segundo Nombre</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asistencias as $asistencia)
            <tr>
                <td class="align-middle">{{$asistencia->dni}}</td>
                <td class="align-middle">{{ucwords($asistencia->apellido_paterno)}}</td>
                <td class="align-middle">{{ucwords($asistencia->apellido_materno)}}</td>
                <td class="align-middle">{{ucwords($asistencia->primer_nombre)}}</td>
                <td class="align-middle">{{ucwords($asistencia->segundo_nombre)}}</td>
                <td class="align-middle">{{$asistencia->created_at->format('d/m/Y')}}</td>
                <td class="align-middle">{{$asistencia->created_at->format('H:i:s')}}</td>
                <td class="align-middle">
                    @if ($asistencia->estado == 'puntual')
                        <p class = "puntual">{{$asistencia->estado}}</p>
                    @else
                        <p class = "tardanza">{{$asistencia->estado}}</p>
                    @endif
                </td>
            </tr>
            @endforeach   
        </tbody>
    </table>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.4/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
    <script src="{{asset('js/datatable.js')}}"></script>
@endsection