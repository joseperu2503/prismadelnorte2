
@extends((auth()->user()->role == 'profesor') ? 'layouts.appProfesor' : 'layouts.appAdmin')

@section('title','Cursos')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
@endsection

@section('content')
    <nav style="padding: 40px 0">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Publicaciones</button>
      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Notas</button>

    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="container-sm col-12 offset-0 col-md-8 offset-md-2 p-0">
                <h1 class="titulo">Publicaciones del curso</h1>
                <div class="btn-group mb-4">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Nuevo
                    </button>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('post.curso.create',[$curso->id,'publicacion'])}}">Publicacion</a></li>
                    <li><a class="dropdown-item" href="#">Tarea</a></li>         
                    </ul>
                </div>

                <div id="post-data">
                    @include('admin.posts')       
                </div>  

                <x-spinner-post/>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <h1 class="titulo">{{$curso->nombre." - ".$aula->aula}}</h1>
            <a href="{{route('nota.create',$curso->id)}}" class="btn btn-success mb-4">Agregar Notas</a>
            
            @foreach ($bimestres as $bimestre)
            
                <h2 class="titulo-2">{{$bimestre->bimestre}} Bimestre</h2>
                <div class="table-responsive p-1">
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
                                            <a href="{{route('nota.edit',[$curso->id,$bimestre->id,$evaluacion->id_evaluacion,$evaluacion->num_evaluacion])}}" class="btn btn-warning btn-sm btn-icon">                            
                                                <i class="fas fa-pen-square"></i>                        
                                            </a> 
                                            <form title="Eliminar" action="{{route('nota.destroy')}}" method="post" class="formEliminar">
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
        </div>
    </div>
    
    
    

@endsection

@section('js')
    <script>
        let postData = document.getElementById('post-data');
        var miFuncion = function(){             
            postData.querySelectorAll('.post').forEach(post => {               
                let comentarioContainer = post.querySelector('.comentarios-container');
                let form = post.querySelector('#form')
                
                if (!post.classList.contains( 'post-load' )) {                 
                    var buttonComentario = function(){
                        let header = comentarioContainer.querySelector('.comentario-header');
                        let body = comentarioContainer.querySelector('.comentario-body');  
                        let comentarios = body.querySelectorAll('.comentario');
                        if(comentarios.length > 0){
                            console.log('ok')
                            comentarios[comentarios.length-1].classList.remove('comentario-disabled');
                            header.addEventListener('click', event => {                            
                                for (i = 0; i < comentarios.length-1; ++i) {
                                    comentarios[i].classList.toggle('comentario-disabled');
                                }                                               
                            })
                            comentarioContainer.style.display = 'block';
                        }
                    }
                    
                    buttonComentario();
                    
                    post.classList.add('post-load');
                    let botonEnviar=form.querySelector('#enviar')
                    
                                   
                    var agregarComentarioFunction = function(){

                        var data = new FormData(form)
                        fetch('{{ route('comentarios.store') }}',{
                           
                            method:'POST',
                            body: data

                        }).then(response => response.json())
                        .then(data => {
                            console.log('ok')              
                            comentarioContainer.innerHTML=data.html;
                            buttonComentario(); 
                        });
                    };

                    botonEnviar.addEventListener('click', agregarComentarioFunction);
                }
            })
        };

        miFuncion();

        function loadMoreData(page)
        {
            $.ajax({
                url:'?page=' + page,
                type: 'get',
                beforeSend: function(){
                    $('#spinner-post').removeClass("spinner-disabled");
                }
            })
            .done(function(data){
                if(data.html == ""){
                    $("#spinner-post").html("No hay mas resultados");
                    return;
                }
                $("#spinner-post").addClass("spinner-disabled");
                $('#post-data').append(data.html);
                miFuncion();
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

        // jquery para hacer responsive los videos de youtube
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="ratio ratio-16x9">'+tmp+'</div>');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/sweetAlert.js')}}"></script>
@endsection