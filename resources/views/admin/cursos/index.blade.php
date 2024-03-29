@extends('layouts.appAdmin')

@section('title','Cursos')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
@endsection

@section('content')
    <h1 class="titulo">Cursos</h1>
    <a href="{{route('admin.curso.create')}}" class="btn btn-success mb-4">Nuevo</a>

    <div class="table-responsive p-1">
        <table id="table_id" class = "table table-hover">
            <thead>
                <tr>
                    <th >ID</th>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Profesor</th>		
                    <th scope="col">Aula</th>				
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                <tr>
                    <td class="align-middle">{{$curso->id}}</td>
                    <td class="align-middle">{{$curso->codigo}}</td>
                    <td class="align-middle">{{$curso->nombre}}</td>	
                    <td class="align-middle">{{ucwords($curso->profesor->primer_nombre." ".$curso->profesor->apellido_paterno)}}</td>	
                    <td class="align-middle">{{$curso->aula->aula}}</td>								
                    <td class="align-middle">     
                        <form action="{{route('admin.curso.destroy',$curso->id)}}" method="POST" class="botones formEliminar"> 
                            <a href="{{route('admin.curso.perfil',$curso->id)}}" class="btn btn-success">Entrar</a>
                            <a href="{{route('admin.curso.edit',$curso->id)}}" class="btn btn-warning">Editar</a>
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
    <script>
        $.extend( $.fn.dataTable.defaults, {
            order: []
        });
    </script>
    <script src="{{asset('js/sweetAlert.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection