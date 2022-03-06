@extends('layouts.appAlumno')

@section('title','Home')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
@endsection
@section('content')

<h1 class="titulo">Inicio</h1>
@if (session('message'))
    <div class="alert alert-success mt-3" role="alert">
        {{ session('message') }}
    </div>
@endif
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