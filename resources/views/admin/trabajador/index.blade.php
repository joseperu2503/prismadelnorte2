@extends('layouts.appAdmin')

@section('title','Personal Complementario')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
@endsection

@section('content')

    <h1 class="titulo">Personal Complementario</h1>
    <a href="trabajadores/create" class="btn btn-success mb-4">Nuevo</a>

    <div class="table-responsive">
        <table id="table_id" class = "table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>		
                    <th scope="col">Primer Nombre</th>	
                    <th scope="col">Segundo Nombre</th>
                    <th scope="col">Puesto</th>					
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trabajadores as $trabajador)
                <tr>
                    <td class="align-middle">{{$trabajador->id}}</td>
                    <td class="align-middle">{{$trabajador->dni}}</td>
                    <td class="align-middle">{{ucwords($trabajador->apellido_paterno)}}</td>	
                    <td class="align-middle">{{ucwords($trabajador->apellido_materno)}}</td>	
                    <td class="align-middle">{{ucwords($trabajador->primer_nombre)}}</td>
                    <td class="align-middle">{{ucwords($trabajador->segundo_nombre)}}</td>	
                    <td class="align-middle">{{ucwords($trabajador->puesto)}}</td>							
                    <td class="align-middle">     
                        <form action="{{route('trabajadores.destroy',$trabajador->id)}}" method="POST" class="botones formEliminar">                            
                            <a href="/trabajadores/{{$trabajador->id}}/edit" class="btn btn-warning">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
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
    <script src="{{asset('js/sweetAlert.js')}}"></script>
@endsection