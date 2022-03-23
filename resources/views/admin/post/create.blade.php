@extends((auth()->user()->role == 'profesor') ? 'layouts.appProfesor' : 'layouts.appAdmin')

@section('title','Nueva Publicación')
@section('css')
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">   
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
@endsection
@section('content')
    <h1 class="titulo">
        Nueva @if ($post->tipo == 'publicacion') Publicación @elseif ($post->tipo == 'evaluacion') Evaluación @endif
    </h1>
    
    <div class="form-container">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    - {{ $error }} <br />
                @endforeach
            </div>
        @endif  
        <input type="hidden" id="id_user" value="{{auth()->user()->id}}">
        
        <form  method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div id="estado"></div>
            <input type="hidden" name="id_post" value="{{$post->id}}">

            <label class="form-label">Para:</label>
            <div class="container p-0 mb-3">
                <div class="row">
                    <div id="aulas" class="col-4">
                        @if (!isset($curso_post))
                            <div class="dropdown">
                                <button class="form-select aulas-boton w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="text-align:left">
                                    Todas las aulas
                                </button>
                                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1" style="width: max-content">
                                    <div class="form-check">
                                        <input class="form-check-input todas-aulas"  type="checkbox" value="0" id="flexCheckDefault" placeholder="Todas las aulas" form="form" checked>
                                        <label>
                                            Todas las aulas
                                        </label>
                                    </div>
                                    @foreach ($aulas as $aula)                               
                                    <div class="form-check">
                                        <input class="form-check-input aula-check" name="aulas[]" type="checkbox" value="{{$aula->id}}" id="flexCheckDefault" placeholder="{{$aula->aula}}" form="form" checked>
                                        <label>
                                            {{$aula->aula}}
                                        </label>
                                    </div>
                                    @endforeach 
                                </div>
                            </div>
                        @elseif (isset($curso_post))
                            <div class="dropdown">
                                <button class="form-select aulas-boton w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="text-align:left">
                                    {{$curso_post->aula->aula}}
                                </button>
                                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1" style="width: max-content">
                                    <div class="form-check">
                                        <input class="form-check-input todas-aulas"  type="checkbox" value="0" id="flexCheckDefault" placeholder="Todas las aulas" form="form">
                                        <label>Todas las aulas</label>
                                    </div>
                                    @foreach ($aulas as $aula)                               
                                    <div class="form-check">
                                        <input class="form-check-input aula-check" name="aulas[]" type="checkbox" value="{{$aula->id}}" id="flexCheckDefault" placeholder="{{$aula->aula}}" form="form" @if($curso_post->aula->id == $aula->id) checked @endif>
                                        <label>{{$aula->aula}}</label>
                                    </div>
                                    @endforeach 
                                </div>
                            </div>
                        @endif
                        
                    </div>                
                    <div id="alumnos" class="col-4">
                        @if (!isset($curso_post))
                        <button class="form-select w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" disabled style="text-align:left">
                            Todos los Alumnos
                        </button>
                        @elseif (isset($curso_post))
                        @include('render.alumnos')
                        @endif
                    </div>
                    <div id="cursos" class="col-4">
                        @if (!isset($curso_post))
                        <button class="form-select w-100" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false" disabled style="text-align:left">
                            Curso
                        </button>
                        @elseif (isset($curso_post))
                        <select id="id_curso" name="id_curso" class="form-select w-100" form="form">
                            <option disabled value="">Curso</option>
                            @foreach ($curso_post->aula->cursos as $curso)
                                <option value="{{$curso->id}}" @if($curso_post->id == $curso->id) selected @endif>{{$curso->nombre}}</option>
                            @endforeach                                     
                        </select>
                        @endif
                        
                    </div>
                </div>
            </div>
           

            <label class="form-label">Título*</label>
            <input id="titulo" name="titulo" type="text" class="form-control mb-3" value="{{old('titulo')}}" required>           
            
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
        </form>

        <form method="post" id="archivos-form">
            @csrf
            <label class="form-label mt-3">Archivos</label>
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
        @if ($post->tipo == 'evaluacion')
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name='recibir' value="si" form="form">
            <label class="form-check-label" for="flexSwitchCheckDefault">Recibir archivos de los alumnos</label>
        </div>  
        @endif
        

        <div class="buttons-form mt-5">
            <a href="javascript:history.back()" class="btn btn-danger">Cancelar</a>
                                    
            <div class="btn-group">
                <button type="submit" form="form" class="btn btn-success" id="publicar1">Publicar</button>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" id="otras-opciones">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"><button type="submit" form="form" style="border:none;width:100%;text-align:left" class="bg-transparent" id="publicar2">Publicar</button></a></li>
                    <li><a class="dropdown-item"><button type="button" style="border:none;width:100%;text-align:left" class="bg-transparent" id="boton-programar" data-bs-toggle="modal" data-bs-target="#exampleModal">Programar</button></a></li>
                    <li><a class="dropdown-item"><button type="submit" form="form" style="border:none;width:100%;text-align:left" class="bg-transparent" id="borrador">Guardar borrador</button></a></li>                            
                </ul>
            </div>
        </div> 
    </div>
   
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Programar publicación</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Fecha y hora programada:</label>
                <input class="form-control mb-3" type="date" name="fecha" id="fecha-programada" form="form" value="">
                <input class="form-control" type="time" name="hora" id="hora-programada" form="form">
                <div id="fecha-error" class="form-text text-danger"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="programar" form="form">Programar</button>
            </div>
          </div>
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
                ['insert',['link','video']]
            ]
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        let botonPublicar1 = document.querySelector("#publicar1");
        let botonPublicar2 = document.querySelector("#publicar2");
        let botonProgramar = document.querySelector("#programar");
        let botonBorrador = document.querySelector("#borrador");
        let botonOtrasOpciones = document.querySelector("#otras-opciones");
        let estado = document.querySelector("#estado");
        let aulaCheckboxes = document.querySelectorAll(".aula-check");
        let alumnos = document.getElementById('alumnos');
        let cursos = document.getElementById('cursos');     
        let aulasBoton = document.querySelector(".aulas-boton");
        let todasAulasCheckbox = document.querySelector(".todas-aulas");
        var botonDeshabilitar = function($bool){            
            botonPublicar1.disabled = $bool;
            botonOtrasOpciones.disabled = $bool;
        }
        var cursosDeshabilitado = function(){  
            cursos.innerHTML="<button class='form-select w-100' type='button' id='dropdownMenuButton2' data-bs-toggle='dropdown' aria-expanded='false' disabled style='text-align:left'>Curso</button>";         
        }
        var todosLosAlumnos_Deshabilitado = function(){  
            alumnos.innerHTML="<button class='form-select w-100' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false' disabled style='text-align:left'>Todos los alumnos</button>";         
        }
        var ningunAlumno_Deshabilitado = function(){  
            alumnos.innerHTML="<button class='form-select w-100' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false' disabled style='text-align:left'>Ningun alumno</button>";         
        }


        var verificarAlumnosSeleccionados = function(){
            let alumnoCheckboxes = document.querySelectorAll(".alumno-check");
            let todoAlumnosCheckbox = document.querySelector(".todos-alumnos");
            let alumnosBoton = document.querySelector(".alumnos-boton");
            todoAlumnosCheckbox.addEventListener('change', function(){
                if(todoAlumnosCheckbox.checked==true){
                    alumnoCheckboxes.forEach( checkbox => {
                        checkbox.checked=true;
                    })
                    alumnosBoton.innerHTML="Todos los alumnos"
                    botonDeshabilitar(false);
                }
                else{
                    alumnoCheckboxes.forEach( checkbox => {
                        checkbox.checked=false;
                    })
                    alumnosBoton.innerHTML="Ningun alumno"
                    botonDeshabilitar(true);
                }
            })
            alumnoCheckboxes.forEach( checkbox => {

                checkbox.addEventListener('change', function(){
                    numeroAlumnosSeleccionados = document.querySelectorAll(".alumno-check:checked").length;
                    if(numeroAlumnosSeleccionados != alumnoCheckboxes.length){
                        todoAlumnosCheckbox.checked=false;                               
                        if(numeroAlumnosSeleccionados == 0){
                            alumnosBoton.innerHTML="Ningun alumno" 
                            botonDeshabilitar(true);
                        }else{
                            alumnosBoton.innerHTML=numeroAlumnosSeleccionados + " alumnos"
                            botonDeshabilitar(false);
                        }  
                    }else{
                        todoAlumnosCheckbox.checked=true;
                        alumnosBoton.innerHTML="Todos los alumnos"
                        botonDeshabilitar(false);
                    }
                })
            })
        }

        @if (isset($curso_post))
        verificarAlumnosSeleccionados();
        @endif

        todasAulasCheckbox.addEventListener('change', function(){
            if(todasAulasCheckbox.checked==true){
                aulaCheckboxes.forEach( checkbox => {
                    checkbox.checked=true;
                })
                aulasBoton.innerHTML="Todas las aulas"
                cursos.innerHTML=""
                botonDeshabilitar(false);
                cursosDeshabilitado();
                todosLosAlumnos_Deshabilitado();
            }
            else{
                aulaCheckboxes.forEach( checkbox => {
                    checkbox.checked=false;
                })
                aulasBoton.innerHTML="Ninguna aula"
                cursos.innerHTML=""
                botonDeshabilitar(true);
                cursosDeshabilitado();
                ningunAlumno_Deshabilitado(); 
            }
        })

        aulaCheckboxes.forEach( checkbox => {
            
            checkbox.addEventListener('change', function(){
                numeroAulasSeleccionadas = document.querySelectorAll(".aula-check:checked").length;
                if(numeroAulasSeleccionadas != aulaCheckboxes.length){
                    todasAulasCheckbox.checked=false;
                    if(numeroAulasSeleccionadas == 1){
                        aulaUnicaSeleccionada = document.querySelector(".aula-check:checked");
                        console.log(aulaUnicaSeleccionada.value);
                        aulasBoton.innerHTML=aulaUnicaSeleccionada.placeholder;
                        botonDeshabilitar(false);
                        fetch('{{route('post.alumnos')}}',{                        
                            method:'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                "X-CSRF-Token": csrfToken
                            },
                            body: JSON.stringify({id_aula: aulaUnicaSeleccionada.value})
                        }).then(response => response.json())
                        .then(data => {
                            console.log('ok')        
                            alumnos.innerHTML=data.html1;
                            cursos.innerHTML=data.html2;
                            verificarAlumnosSeleccionados();

                        });
                    }
                    else{ 
                        todosLosAlumnos_Deshabilitado();
                        cursosDeshabilitado();
                        if(numeroAulasSeleccionadas == 0){
                            aulasBoton.innerHTML="Ninguna aula" 
                            botonDeshabilitar(true);
                        }else{
                            aulasBoton.innerHTML=numeroAulasSeleccionadas + " aulas"
                            botonDeshabilitar(false);
                        }
                        
                    }
                }else{
                    todasAulasCheckbox.checked=true;
                    todosLosAlumnos_Deshabilitado();
                    cursosDeshabilitado();
                    aulasBoton.innerHTML="Todas las aulas"
                    botonDeshabilitar(false);
                }
            })
        })
      

        let x = 0;
        let postForm = document.getElementById('form');
        botonPublicar1.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='publicar'>"
            postForm.action = "{{route('admin.post.store')}}"
            x=1;
        })
        botonPublicar2.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='publicar'>"
            postForm.action = "{{route('admin.post.store')}}"
            x=1;
        })

        botonProgramar.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='programar'>"
            postForm.action = "{{route('admin.post.store')}}"
            x=1;
        })
        
        botonBorrador.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='borrador'>"
            postForm.action = "{{route('admin.post.store')}}"
            x=1;
        })


        //VALIDACION DE FECHA PROGRAMADA
        let fechaProgramada = document.getElementById('fecha-programada');
        let horaProgramada = document.getElementById('hora-programada');
        let fechaError = document.getElementById('fecha-error');  
        let botonProgramarModal = document.getElementById('boton-programar');
        var fecha_actual = new Date();  
        let tomorrow = new Date();
        tomorrow.setDate(fecha_actual.getDate() + 1);
        console.log(tomorrow);

        let day = tomorrow.getDate()
        let month = tomorrow.getMonth() + 1
        let year = tomorrow.getFullYear()

        if(month < 10){
            mañana = year+"-0"+month+"-"+day
        }else{
            mañana = year+"-"+month+"-"+day
        }
        var verificarFecha = function(){
            
            var fecha=fechaProgramada.value
            var hora=horaProgramada.value
            var fechaHora = new Date(fecha+" "+hora).toISOString()
            console.log(fecha_actual.getTime())
            console.log(fechaProgramada.value)
            if(fechaHora <= fecha_actual.toISOString()){
                fechaProgramada.classList.add('is-invalid')
                fechaError.innerHTML="Debe programarse para el futuro"
                botonProgramar.disabled=true
            }
            else{
                fechaProgramada.classList.remove('is-invalid')
                fechaError.innerHTML=""
                botonProgramar.disabled=false
            }
        }
        fechaProgramada.addEventListener('change',verificarFecha)
        horaProgramada.addEventListener('change',verificarFecha)
        botonProgramarModal.addEventListener('click',function(){
            fechaProgramada.value= mañana
            horaProgramada.value= '08:00'
        })

        //Al salir de la pagina eliminará el post
        window.addEventListener('beforeunload', function(event) {
            if(x==0){
                event.preventDefault();
                fetch('{{route('post.delete.crear')}}',{                        
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": csrfToken
                    },
                    body: JSON.stringify({id_post: '{{$post->id}}'})
                }).then(response => response.json())
                .then(data => {
                    return true; 
                })
            }
            
        });
    </script>
@endsection