@extends((auth()->user()->role == 'profesor') ? 'layouts.appProfesor' : 'layouts.appAdmin')

@section('title','Cursos')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')

    <h1 class="titulo">{{mb_convert_case($curso->nombre, MB_CASE_TITLE, "UTF-8")." - ".$aula->aula}}</h1>
    
    <div class="editar-notas-container">
        <h2 class="agregar-notas">Editar Notas</h2>    
    </div>
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                - {{ $error }} <br />
            @endforeach
        </div>
    @endif
    <form action="/curso/{{$curso->id}}/update" method="post" class="form-notas">
        @csrf
        @method('PUT')   
        <div class="tipo_evaluacion">
            <label class="form-label">Bimestre</label>
            <select name="id_bimestre" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($bimestres as $bimestre)
                    @if ($evaluacion_datos->id_bimestre == $bimestre->id)
                        <option selected value="{{$bimestre->id}}">{{$bimestre->bimestre}} Bimestre</option>
                    @else
                        <option value="{{$bimestre->id}}">{{$bimestre->bimestre}} Bimestre</option>
                    @endif
                    
                @endforeach                                     
            </select>
            <label class="form-label">Tipo de evaluación</label>
            <select name="id_evaluacion" class="form-select mb-3" required>
                <option selected disabled value="">Seleccione una opción</option>
                @foreach ($evaluaciones as $evaluacion)
                    @if ($evaluacion_datos->id_evaluacion == $evaluacion->id)
                        <option selected value="{{$evaluacion->id}}">{{$evaluacion->evaluacion}}</option>
                    @else
                        <option value="{{$evaluacion->id}}">{{$evaluacion->evaluacion}}</option>
                    @endif                       
                @endforeach                                     
            </select>           
            <label class="form-label">Numero de evaluación</label>
            <input id="num_evaluacion" name="num_evaluacion" type="number" class="form-control mb-3" value="{{$evaluacion_datos->num_evaluacion}}" required>                  
        </div>
        <div class="table-responsive">
            <table class = "table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Alumno</th>
                        <th scope="col">Nota</th>
                    </tr>  
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr>
                            <td class="align-middle"><img class = "foto" src="{{$alumno->foto_perfil}}" alt=""></td>
                            <td class="align-middle">{{ucwords($alumno->apellido_paterno." ".$alumno->apellido_materno." ".$alumno->primer_nombre." ".$alumno->segundo_nombre)}}</td>

                            <td class="align-middle"><input type="number" class="form-control mb-3" name="nota_{{$alumno->id}}" @if ($notas_tabla["$alumno->id"]=='nsp')
                                placeholder="NSP"
                            @else placeholder="Insertar" @endif  value="{{$notas_tabla["$alumno->id"]}}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="buttons-form"> 
            <a href="/curso/{{$curso->id}}" class="btn btn-danger">Cancelar</a>       
            <input type="submit" class = "btn btn-success" value = "Enviar">
        </div>
        <input type="hidden" name="id_evaluacion_antiguo" value="{{$evaluacion_datos->id_evaluacion}}">
        <input type="hidden" name="num_evaluacion_antiguo" value="{{$evaluacion_datos->num_evaluacion}}">
        <input type="hidden" name="id_curso_antiguo" value="{{$evaluacion_datos->id_curso}}">
        <input type="hidden" name="id_bimestre_antiguo" value="{{$evaluacion_datos->id_bimestre}}">
    </form>  
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection