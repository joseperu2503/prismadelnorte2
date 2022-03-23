<div class="card  mb-4 shadow p-0 post" id="post">   
    <div class="d-flex align-items-center gap-3 card-header">
        <div class="d-flex align-items-center gap-3" style="min-width: max-content">
            <div>
                <img src="{{$post->fotoautor}}" style="width:40px;height: 40px;object-fit: cover">
            </div>
            
            <div>
                <p class="fw-bold my-0">{{$post->autor}}</p>
                @if ($post->estado=='publicar')
                <p class="card-text"><small class="text-muted">{{$post->fechacreacion}}</small></p>
                @elseif($post->estado=='borrador')
                <p class="card-text"><small class="text-danger">Borrador</small></p>   
                @elseif($post->estado=='programar')
                <p class="card-text"><small class="text-success">Se publicará {{$post->fechacreacion}}</small></p>
                @endif
                
            </div>
        </div>    
        <div class="w-100">

        </div>
        @if ($post->id_user == auth()->user()->id)
        <div class="dropdown">
            <button class="dropdown-toggle puntos" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="{{route('admin.post.edit',[$post->tipo,$post->id])}}">Editar</a></li>
                <li>
                    <form action="{{route('admin.post.destroy',$post->id)}}" method="POST" class="dropdown-item formEliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border: none; background:transparent">Eliminar</button>
                    </form>
                </li>
            </ul>
        </div> 
        @endif
    </div>
    
    {{-- imagen de portada --}}
    @if (isset($post->imagen))
        <div class="d-flex justify-content-center mt-3">
            <img src="{{$post->imagen}}" style="width: 100%;max-height: 600px;object-fit: contain">
        </div>
    @endif    
    {{-- video de youtube --}} 
    @if (isset($post->iframe))
        <div class="ratio ratio-16x9 mt-3" >
            {!! $post->iframe !!}
        </div>
    @endif 
       
    <div class="card-body" id="card-body">
        <h3 class="card-title mb-3">{{$post->titulo}}</h3>
        {!! $post->descripcion !!}
        <div class="mb-3"></div>
        {{-- archivos --}}

        @if (isset($post->carpeta))
        <div class="archivos-grid my-3">
            @foreach ($post->archivos->where('estado','publicar') as $archivo)
                <x-archivo :archivo="$archivo" tipo="mostrar" idPost='1'/>
            @endforeach
        </div>
        @endif   

        {{-- Tag del curso --}}
        @if ($post->id_curso!=null)
            <div>
                <a @if (auth()->user()->role=='admin') href="{{route('admin.curso.perfil',$post->curso->id)}}"
                    @elseif(auth()->user()->role=='profesor')  href="{{route('profesor.curso.perfil',$post->curso->id)}}"     
                    @elseif(auth()->user()->role=='alumno')  href="/alumno/cursos/{{$post->curso->codigo}}" 
                    @endif class="btn btn-outline-primary btn-sm rounded-pill">
                    {{$post->curso->nombre}}
                </a>
            </div>          
        @endif                     
    </div>

    {{-- Comentarios --}}
    @if ($post->comentarios->count() > '0')
        
        <div class="comentarios-container px-3 border-top">
            @include('render.comentarios') 
        </div>                  
    @else
        <div class="comentarios-container px-3 border-top" style="display: none">
            @include('render.comentarios') 
        </div>
    @endif
    
    {{-- Agregar comentario --}}
    <div class="card-footer bg-transparent border-top" id="agregar-comentario">    
        <form method="post" class="d-flex align-items-center gap-3" id="form">
            @csrf
            <div>
                <img src="{{auth()->user()->foto}}" style="width:2rem;height:2rem;object-fit:cover; border-radius:1rem">    
            </div>
            <div class="w-100">  
                <textarea class="form-control" name="descripcion" id="exampleFormControlTextarea1" rows="1" placeholder="Agregar comentario" required ></textarea>
            </div>
            <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
            <input type="hidden" name="id_post" value="{{$post->id}}">
            <button class="enviar-comentario deshabilitado" type="button" id="enviar">
                <i class="fas fa-arrow-right"></i>
            </button>
                            
        </form>
    </div>
</div>



{{-- <script>
    function habilitar()
    {
    if (document.getElementById("exampleFormControlTextarea1").value == '') {
        document.getElementById("enviar").disabled = true;
        document.getElementById("enviar").classList.add("deshabilitado");
    } else {
        document.getElementById("enviar").disabled = false;
        document.getElementById("enviar").classList.remove("deshabilitado");
    }
    }
</script> --}}