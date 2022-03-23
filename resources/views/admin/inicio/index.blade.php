@extends('layouts.appAdmin')

@section('title','Inicio')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

@endsection
@section('content')
    <div class="container-sm col-12 offset-0 col-md-8 offset-md-2 p-0">
        <h1 class="titulo">Inicio</h1>
        <div class="btn-group mb-4">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Crear
            </button>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('admin.post.create','publicacion')}}">Publicación</a></li>
            <li><a class="dropdown-item" href="{{route('admin.post.create','evaluacion')}}">Evaluación</a></li>     
            </ul>
        </div>

        <div id="post-data">
            @include('admin.posts')       
        </div>                
        <x-spinner-post/>
    </div>
    
    
@endsection

@section('js')
    
    <script>
        let postData = document.getElementById('post-data');
        var verificarPosts = function(){             
            postData.querySelectorAll('.post').forEach(post => {                             
                if (!post.classList.contains( 'post-load' )) { 
                    let comentarioContainer = post.querySelector('.comentarios-container');
                    let form = post.querySelector('#form')
                    let comentarioInput = post.querySelector('.form-control')                
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
                    botonEnviar.disabled = true;
                    comentarioInput.oninput = function(){
                        if(comentarioInput.value.length == 0){
                            botonEnviar.disabled = true;
                            botonEnviar.classList.add('deshabilitado')
                        }else{
                            botonEnviar.disabled = false;
                            botonEnviar.classList.remove('deshabilitado')

                        }
                    }
                              
                    var agregarComentario = function(){
                        var data = new FormData(form)
                        fetch('{{ route('comentarios.store') }}',{
                           
                            method:'POST',
                            body: data

                        }).then(response => response.json())
                        .then(data => {
                            console.log('ok')              
                            comentarioContainer.innerHTML=data.html;
                            buttonComentario(); 
                            comentarioInput.value=""
                            botonEnviar.disabled = true;
                            botonEnviar.classList.add('deshabilitado')
                        });
                    };

                    botonEnviar.addEventListener('click', agregarComentario);


                    comentarioInput.addEventListener('keydown', autosize);
                                
                    function autosize(){
                        var el = this;
                        setTimeout(function(){
                            el.style.cssText = 'height:auto; padding:0';
                            el.style.cssText = 'height:' + el.scrollHeight + 'px';
                        },0);
                    }
                }
            })
        };

        verificarPosts();

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
                verificarPosts();
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
    <script>
        // //script para la altura automatica del areatext
        // $("textarea").keyup(function(){  
        //     var height = $(this).prop("scrollHeight")+2+"px";
        //     $(this).css({"height":height});
        // })
    </script>
    <script src="{{asset('js/sweetAlert.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

@endsection