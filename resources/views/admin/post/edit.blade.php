@extends('layouts.appAdmin')

@section('title','Editar Publicación')
@section('css')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">   
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('content')
    <h1 class="titulo">Editar Publicación</h1>
    <div class="form-container">  
        <form action="/publicaciones/{{$post->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label class="form-label">Título</label>
            <input id="titulo" name="titulo" type="text" class="form-control mb-3" value="{{$post->titulo}}">           
            
            <label class="form-label">Imagen</label>
            <label class="btn btn-outline-primary w-100 mb-3">
                <i class="fas fa-image"></i>
                <p class="m-0">Seleccione la imagen</p>
                <input id="imagen" type="file" name="imagen" class="hidden" >
            </label>
            <div class="d-flex justify-content-center my-3">
                <img src="{{$post->imagen}}" class="col-12 col-sm-8 col-md-6"  id="imagenSeleccionada">
            </div>  
    
            <label class="form-label">Descripción</label>
            <textarea id="summernote" name="descripcion" type="text" class="form-control mb-3" rows="5">{{$post->descripcion}}</textarea>
            <label class="form-label mt-3">Contenido embebido</label>
            <input id="iframe" name="iframe" type="text" class="form-control mb-3" value="{{$post->iframe}}">           
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        - {{ $error }} <br />
                    @endforeach
                </div>
            @endif
            <div class="buttons-form">
                <a href="/publicaciones" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>          
        </form>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script>   
        $(document).ready(function (e) {   
            $('#imagen').change(function(){            
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#imagenSeleccionada').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });
        });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    {{-- Summer editor --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $('#summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'fontname', 'fontsize','color']],
                ['font', ['superscript', 'subscript']],
                ['para', ['style','ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert',['link']]
            ]
        });
    </script>
@endsection