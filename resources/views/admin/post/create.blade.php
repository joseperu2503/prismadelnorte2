@extends((auth()->user()->role == 'profesor') ? 'layouts.appProfesor' : 'layouts.appAdmin')

@section('title','Nueva Publicación')
@section('css')
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">   
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

   
@endsection
@section('content')
    <h1 class="titulo">Nueva Publicación</h1>
    {{$post->id}}
    <div class="form-container">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    - {{ $error }} <br />
                @endforeach
            </div>
        @endif  
        <form action="{{route('publicaciones.store')}}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <label class="form-label">Título</label>
            <input id="titulo" name="titulo" type="text" class="form-control mb-3" value="{{old('titulo')}}">           
            
            <label class="form-label">Imagen de portada</label>
            <label class="btn btn-outline-primary w-100 mb-3">
                <i class="fas fa-image"></i>
                <p class="m-0">Seleccione la imagen</p>
                <input id="imagen" type="file" name="imagen" class="hidden" >
            </label>
            <div class="d-flex justify-content-center my-3">
                <img class="col-12 col-sm-8 col-md-6"  id="imagenSeleccionada">
            </div>  
    
            <label class="form-label">Descripción</label>
            <textarea id="summernote" name="descripcion" type="text" class="form-control mb-3" rows="5" >{{old('descripcion')}}</textarea>
            <label class="form-label mt-3">Contenido embebido</label>
            <input id="iframe" name="iframe" type="text" class="form-control mb-3" value="{{old('iframe')}}">           
            

            <input type="hidden" name="id_post" value="{{$post->id}}">

            @if (isset($curso->id))
                <input type="hidden" name="id_curso" value="{{$curso->id}}">
            @endif           
                     
        </form>

        <form method="post" id="archivos-form">
            @csrf
            <label class="form-label">Archivos</label>
            <input type="file" class="form-control mb-3" name="archivos[]" multiple id="formFileMultiple">
            <input type="hidden" name="id_post" value="{{$post->id}}">
        </form>

        @include('render.archivos')

        <div id="spinner-cargando" style="display: none" class="my-4">
            <div class="d-flex flex-column align-items-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando archivos...</span>
                </div>
                <div>
                    Cargando archivos...
                </div>
            </div>
        </div>
        <div id="spinner-eliminando" style="display: none" class="my-4">
            <div class="d-flex flex-column align-items-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando archivos...</span>
                </div>
                <div>
                    Eliminando archivos...
                </div>
            </div>
        </div>
        

        <div class="buttons-form mt-5">
            <form method="post" id="cancelar-form">
                @csrf
                <input type="hidden" name="id_post" value="{{$post->id}}">
                <button type="button" class="btn btn-danger" id="cancelar">Cancelar</button>
            </form>
            
            <button type="submit" form="form" class="btn btn-success">Publicar</button>
        </div> 
    </div>
@endsection
@section('js')  

    <script>
        let spinnerCargando = document.getElementById('spinner-cargando');   
        let spinnerEliminando = document.getElementById('spinner-eliminando');      
        let archivosForm = document.getElementById('archivos-form');
        archivosForm.addEventListener('change', function(){
            
            spinnerCargando.style.display = 'block';
            var data = new FormData(archivosForm);
            fetch('{{ route('archivos.store') }}',{               
                method:'POST',
                body: data
            }).then(response => response.json())
            .then(data => { 
                spinnerCargando.style.display = 'none';              
                var archivosGrid = document.getElementById('archivos-grid');
                archivosGrid.outerHTML=data.html;   
                document.getElementById("archivos-form").reset();
                var botonArchivo = function(){
                    var archivosGrid = document.getElementById('archivos-grid');
                    let archivos = archivosGrid.querySelectorAll('.archivo-container');
                    if(archivos.length > 0){               
                        archivosGrid.querySelectorAll('.archivo-container').forEach(archivo => {           
                            let form = archivo.querySelector('#eliminar-archivo');
                            var eliminarArchivo = function(){
                                spinnerEliminando.style.display = 'block';
                                var data = new FormData(form)
                                fetch('{{route('archivo.delete')}}',{                        
                                    method:'POST',
                                    body: data
                                }).then(response => response.json())
                                .then(data => {
                                    spinnerEliminando.style.display = 'none';             
                                    archivosGrid.outerHTML=data.html;
                                    botonArchivo();   
                                });
                            };

                            archivo.querySelector('#eliminar').addEventListener('click', eliminarArchivo);

                        });                             
                    }
                } 
                botonArchivo();         
            });            
        });   
        let cancelarBoton = document.getElementById('cancelar');     
        var dataCancelar = new FormData(document.getElementById('cancelar-form'));  
        cancelarBoton.addEventListener('click',function(){
            fetch('{{route('post.delete')}}',{                        
                method:'POST',
                body: dataCancelar

            }).then(window.history.back());

        });


    </script>

    {{-- Scripts para mostrar la imagen cuando se seleccione --}}
    
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