@extends('layouts.appAlumno')

@section('title','Mis notas - '.$curso->nombre)
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
@endsection
@section('content')

    <h1 class="titulo text-capitalize">{{$curso->nombre}}</h1>

    <div class="accordion" id="accordionPanelsStayOpenExample">
        @foreach ($bimestres as $bimestre)
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading{{$bimestre->num_ingles}}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$bimestre->num_ingles}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$bimestre->num_ingles}}">
                    {{$bimestre->bimestre}} Bimestre
                </button>
            </h2>
            <div id="panelsStayOpen-collapse{{$bimestre->num_ingles}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{$bimestre->num_ingles}}">
                <div class="accordion-body">
                    @if ($notas_tabla["$bimestre->id"]!=null)
                        <div class="container-sm col-12 col-md-6">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Evaluación
                                        </th>
                                        <th class="justify-content-center row align-items-center">
                                            Nota
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evaluaciones as $evaluacion)
                                        @if ($evaluacion->id_bimestre == $bimestre->id)
                                            <tr>
                                                <td>
                                                    {{$evaluacion->evaluacion}} {{$evaluacion->num_evaluacion}}
                                                </td>
                                                <td class="justify-content-center row align-items-center">                                                   
                                                    @if ($notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]=='NSP')
                                                        <p class = "nota-nsp">{{$notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]}}</p>                            
                                                    @elseif((int)$notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]<10)
                                                        <p class = "nota-desaprobada">{{$notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]}}</p>                                            
                                                    @elseif((int)$notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]>=10)
                                                        <p class = "nota-aprobada">{{$notas_tabla["$bimestre->id"]["$evaluacion->id_evaluacion $evaluacion->num_evaluacion"]}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif         
                                    @endforeach	
                                </tbody>
                            </table>
                        </div>
                    @else
                        Aun no hay notas disponibles
                    @endif
                </div>
            </div>
          </div>
        @endforeach
    </div> 

    <h1 class="titulo">Publicaciones del curso</h1>
    <a href="/curso/{{$curso->id}}/crear_publicacion" class="btn btn-success">Crear publicación</a>
    <div class="container">
        <div class="row" id="post-data">
            @include('alumno.posts')       
        </div>  
    </div>
@endsection
@section('js')
    <script>
        function loadMoreData(page)
        {
            $.ajax({
                url:'?page=' + page,
                type: 'get',
                beforeSend: function(){
                    $(".ajax-load").show();
                }
            })
            .done(function(data){
                if(data.html == " "){
                    $('.ajax-load').html("No more reords found");
                    return;
                }
                $('.ajax-load').hide();
                $('#post-data').append(data.html);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError){
                alert("Server not responding..")
            });
        }

        var page = 1;
        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() >= $(document).height()){
                page++;
                loadMoreData(page);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
@endsection

