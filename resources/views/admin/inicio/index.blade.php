@extends('layouts.appAdmin')

@section('title','Inicio')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

@endsection
@section('content')
    <h1 class="titulo">Inicio</h1>
    <a href="{{route('publicaciones.create')}}" class="btn btn-success mb-4">Nueva publicación</a>
    <div class="container">
        <div class="row" id="post-data">
            @include('admin.posts')          
        </div>      
    </div>
    <div class="d-flex justify-content-center ajax-load" style="display: none">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
@endsection

@section('js')
    
    <script>

        var miFuncion = function(){  
            let postData = document.getElementById('post-data');

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

                    form.querySelector('#enviar').addEventListener('click', agregarComentarioFunction);
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
                    $('.ajax-load').show();
                }
            })
            .done(function(data){
                if(data.html == ""){
                    $(".ajax-load").html("No hay mas resultados");
                    return;
                }
                $(".ajax-load").hide();
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