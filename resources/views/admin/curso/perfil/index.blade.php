
@extends((auth()->user()->role == 'profesor') ? 'layouts.appProfesor' : 'layouts.appAdmin')

@section('title','Cursos')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection

@section('content')

    <h1 class="titulo">{{$curso->nombre." - ".$aula->aula}}</h1>
    <a href="/curso/{{$curso->id}}/agregar_notas" class="btn btn-success">Agregar Notas</a>
    
    @foreach ($bimestres as $bimestre)
       
        <h2 class="titulo-2">{{$bimestre->bimestre}} Bimestre</h2>
        <div class="table-responsive">
            <table class = "table table-hover table-notas">
                <thead>
                    <tr>
                        <th scope="col">Alumno</th>
                        @foreach ($evaluaciones as $evaluacion)
                            @if($evaluacion->id_bimestre == $bimestre->id)
                                <td class="align-middle">
                                    <div class="evaluacion">
                                        {{$evaluacion->evaluacion." ".$evaluacion->num_evaluacion}}
                                    </div> 
                                </td>
                            @endif
                        @endforeach
                    </tr>  
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr>
                            <td class="align-middle">{{ucwords($alumno->apellido_paterno." ".$alumno->apellido_materno." ".$alumno->primer_nombre." ".$alumno->segundo_nombre)}}</td>
                            @foreach ($evaluaciones as $evaluacion)
                                @if($evaluacion->id_bimestre == $bimestre->id)
                                    <td class="align-middle">
                                        <div class="justify-content-center row align-items-center">
                                            {{$notas_tabla["$bimestre->id"]["$alumno->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]}}                    
                                        </div>                          
                                    </td>
                                @endif
                            @endforeach                      
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        @foreach ($evaluaciones as $evaluacion)
                            @if($evaluacion->id_bimestre == $bimestre->id)
                            <td>
                                <div class="d-flex justify-content-center gap-2">  
                                    <a href="/curso/{{$curso->id}}/{{$bimestre->id}}/{{$evaluacion->id_evaluacion}}/{{$evaluacion->num_evaluacion}}/editar_nota" class="btn btn-warning btn-sm btn-icon">                            
                                        <i class="fas fa-pen-square"></i>                        
                                    </a> 
                                    <form title="Eliminar" action="/notas/destroy" method="post" class="formEliminar">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id_evaluacion" value="{{$evaluacion->id_evaluacion}}">
                                        <input type="hidden" name="num_evaluacion" value="{{$evaluacion->num_evaluacion}}">
                                        <input type="hidden" name="id_curso" value="{{$curso->id}}">
                                        <input type="hidden" name="id_bimestre" value="{{$evaluacion->id_bimestre}}">
                                        <button type="submit" class="btn btn-danger btn-sm formEliminar btn-icon">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>                           
                                    </form>
                                </div>    
                            </td>                          
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
    
    <h1 class="titulo">Publicaciones del curso</h1>
    <a href="/curso/{{$curso->id}}/crear_publicacion" class="btn btn-success">Crear publicación</a>
    <div class="container">
        <div class="row">
            @foreach ($posts as $post)
                @if ($post->id_curso == $curso->id)
                    <x-post :post="$post"/>   
                @endif         
            @endforeach
        </div>  
    </div>


@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/sweetAlert.js')}}"></script>
@endsection