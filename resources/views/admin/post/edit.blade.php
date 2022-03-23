@extends('layouts.appAdmin')

@section('title','Editar Publicación')
@section('css')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">   
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h1 class="titulo">Editar Publicación</h1>
    <div class="form-container"> 
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    - {{ $error }} <br />
                @endforeach
            </div>
        @endif 
        
        <form  method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div id="estado"></div>
            <input type="hidden" name="id_post" value="{{$post->id}}"> 
            
            <label class="form-label">Para:</label>
            <div class="container p-0 mb-3">
                <div class="row">
                    <div id="aulas" class="col-4">
                        <div class="dropdown">
                            <button class="form-select aulas-boton w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="text-align:left">
                                Todas las aulas
                            </button>
                            <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1" style="width: max-content">
                                <div class="form-check">
                                    <input class="form-check-input todas-aulas"  type="checkbox" value="0" id="flexCheckDefault" placeholder="Todas las aulas" form="form">
                                    <label>
                                        Todas las aulas
                                    </label>
                                </div>
                                @foreach ($aulas as $aula)                               
                                <div class="form-check">
                                    <input class="form-check-input aula-check" name="aulas[]" type="checkbox" value="{{$aula->id}}" id="flexCheckDefault" placeholder="{{$aula->aula}}" form="form" 
                                    @if (in_array($aula->id,$aulas_checked))
                                        checked
                                    @endif>
                                    <label>
                                        {{$aula->aula}}
                                    </label>
                                </div>
                                @endforeach 
                            </div>
                        </div>
                    </div>         
                         
                    <div id="alumnos" class="col-4">
                        @if (isset($alumnos_checked))
                        <div class="dropdown">
                            <button class="form-select alumnos-boton w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="text-align:left">
                                Todos los alumnos
                            </button>
                            <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1" style="width: max-content">
                                <div class="form-check">
                                    <input class="form-check-input todos-alumnos" name="alumnos[]" type="checkbox" value="0" id="flexCheckDefault" placeholder="Todos los alumnos" form="form" @if($alumnos_checked[0]==null)
                                    checked
                                    @endif>
                                    <label>
                                        Todos los alumnos
                                    </label>
                                </div>
                                @foreach ($alumnos as $alumno)                               
                                <div class="form-check">
                                    <input class="form-check-input alumno-check" name="alumnos[]" type="checkbox" value="{{$alumno->id}}" id="flexCheckDefault"  form="form" 
                                        @if (in_array($alumno->id,$alumnos_checked))
                                        checked
                                        @elseif($alumnos_checked[0]==null)
                                        checked
                                        @endif>
                                    <label>
                                        {{$alumno->apellido_paterno}} {{$alumno->primer_nombre}} 
                                    </label>
                                </div>
                                @endforeach 
                            </div>
                        </div>
                        @else
                        <button class="form-select w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" disabled style="text-align:left">
                            Todos los Alumnos
                        </button>
                        @endif                     
                    </div>
                    <div id="cursos" class="col-4">
                        @if (isset($alumnos_checked))
                            <select id="id_curso" name="id_curso" class="form-select w-100" form="form">
                                <option @if($post->id_curso==null) selected @endif value="">Ningun curso</option>
                                @foreach ($cursos as $curso)
                                    <option @if($post->id_curso==$curso->id) selected @endif value="{{$curso->id}}">{{$curso->nombre}}</option>
                                @endforeach                                     
                            </select>
                        @else
                            <button class="form-select w-100" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false" disabled style="text-align:left">
                                Curso
                            </button>                   
                        @endif
                    </div>

                </div>
            </div>        
            <label class="form-label">Título*</label>
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
            
        </form>

        <form method="post" id="archivos-form">
            @csrf
            <label class="form-label mt-3">Archivos</label>
            <input type="file" class="form-control mb-3" name="archivos_editar[]" multiple id="formFileMultiple">
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
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name='recibir' value="si" form="form" @if ($post->recibir == 'si')checked @endif>
            <label class="form-check-label" for="flexSwitchCheckDefault">Recibir archivos de los alumnos</label>
        </div>  
        @endif
        <div class="buttons-form mt-5">
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
            
            
            <div class="btn-group">
                <button type="submit" form="form" class="btn btn-success" id="publicar1"> @if ($post->estado == 'publicar') Actualizar @else Publicar @endif </button>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" id="otras-opciones">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"><button type="submit" form="form" style="border:none;width:100%;text-align:left" class="bg-transparent" id="publicar2"> @if ($post->estado == 'publicar') Actualizar @else Publicar @endif </button></a></li>
                    <li><a class="dropdown-item"><button type="button" style="border:none;width:100%;text-align:left" class="bg-transparent" data-bs-toggle="modal" data-bs-target="#exampleModal">Programar</button></a></li>
                    <li><a class="dropdown-item"><button type="submit" form="form" style="border:none;width:100%;text-align:left" class="bg-transparent" id="borrador">Guardar borrador</button></a></li>                            
                </ul>
            </div>      
        </div>     
    </div>
    {{date("d/m/Y",strtotime($post->fecha_publicacion))}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Programar publicación</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Fecha y hora programada:</label>
                <input class="form-control mb-3" type="date" name="fecha" id="fecha-programada" form="form" value="{{date("Y-m-d",strtotime($post->fecha_publicacion))}}">
                <input class="form-control" type="time" name="hora" id="hora-programada" form="form" value="{{date("H:i",strtotime($post->fecha_publicacion))}}">
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
        var botonArchivo = function(){
            var archivosGrid = document.getElementById('archivos-grid');
            let archivos = archivosGrid.querySelectorAll('.archivo-container');
            if(archivos.length > 0){               
                archivosGrid.querySelectorAll('.archivo-container').forEach(archivo => {           
                    let form = archivo.querySelector('#eliminar-archivo');
                    var eliminarArchivo = function(){
                        spinnerEliminando.style.display = 'block';
                        var data = new FormData(form)
                        fetch('{{route('archivo.delete.editar')}}',{                        
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
                
                botonArchivo();         
            });            
        });    
    </script>
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
    <script >
        let aulaCheckboxes = document.querySelectorAll(".aula-check");
        let alumnos = document.getElementById('alumnos');
        let cursos = document.getElementById('cursos');
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        let aulasBoton = document.querySelector(".aulas-boton");
        let todasAulasCheckbox = document.querySelector(".todas-aulas");
        let botonPublicar1 = document.querySelector("#publicar1");
        let botonPublicar2 = document.querySelector("#publicar2");
        let botonProgramar = document.querySelector("#programar");

        let botonBorrador = document.querySelector("#borrador");
        let botonOtrasOpciones = document.querySelector("#otras-opciones");
        let estado = document.querySelector("#estado");
        var botonDeshabilitar = function($bool){            
            botonPublicar1.disabled = $bool;
            botonOtrasOpciones.disabled = $bool;
        }
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

        var verificarAulasSeleccionadas = function(){
            numeroAulasSeleccionadas = document.querySelectorAll(".aula-check:checked").length;
            if(numeroAulasSeleccionadas != aulaCheckboxes.length){
                todasAulasCheckbox.checked=false;
                if(numeroAulasSeleccionadas == 1){
                    aulaUnicaSeleccionada = document.querySelector(".aula-check:checked");
                    console.log(aulaUnicaSeleccionada.value);
                    aulasBoton.innerHTML=aulaUnicaSeleccionada.placeholder;
                    botonDeshabilitar(false);
                    
                    verificarAlumnosSeleccionados();        
                }
                else{
                    alumnos.innerHTML="<button class='btn btn-light dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false' disabled> Todos los alumnos </button>";
                    cursos.innerHTML=""
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
                aulasBoton.innerHTML="Todas las aulas"
                botonDeshabilitar(false);
            }
        }

        verificarAulasSeleccionadas();

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
            postForm.action = "{{route('admin.post.update')}}"
            x=1;
        })

        botonPublicar2.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='publicar'>"
            postForm.action = "{{route('admin.post.update')}}"
            x=1;
        })
        
        botonProgramar.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='programar'>"
            postForm.action = "{{route('admin.post.update')}}"
            x=1;
        })
        botonBorrador.addEventListener('click',function(){
            estado.innerHTML="<input type='hidden' name='estado' value='borrador'>"
            postForm.action = "{{route('admin.post.update')}}"
            x=1;
        })

        //VALIDACION DE FECHA PROGRAMADA
        let fechaProgramada = document.getElementById('fecha-programada');
        let fechaError = document.getElementById('fecha-error');      
        fechaProgramada.addEventListener('change',function(){
            var fecha_actual = new Date();
            console.log(fecha_actual.getTime())
            console.log(fechaProgramada.value)
            if(new Date(fechaProgramada.value).toISOString() <= fecha_actual.toISOString()){
                fechaProgramada.classList.add('is-invalid')
                fechaError.innerHTML="Debe programarse para el futuro"
                botonProgramar.disabled=true
            }
            else{
                fechaProgramada.classList.remove('is-invalid')
                fechaError.innerHTML=""
                botonProgramar.disabled=false
            }
        })


        //Al salir de la pagina eliminar cambios
        window.addEventListener('beforeunload', function(event) {
            if(x==0){
                event.preventDefault();
                fetch('{{route('post.delete.editar')}}',{                        
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