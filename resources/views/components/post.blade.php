<div class="card col-12 offset-0 mb-4 col-md-8 offset-md-2 mb-4 shadow">   

    @if ($post->id_user == auth()->user()->id)
    <div class="dropdown mt-2">
        <button class="dropdown-toggle puntos" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="/publicaciones/{{$post->id}}/edit">Editar</a></li>
            <li>
                <form action="{{route('publicaciones.destroy',$post->id)}}" method="POST" class="dropdown-item formEliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border: none; background:transparent">Eliminar</button>
                </form>
            </li>
        </ul>
    </div> 
    @endif

    @if (isset($post->imagen))
        <div class="d-flex justify-content-center mt-3">
            <img src="{{$post->imagen}}" style="width: 100%;max-height: 600px;object-fit: contain">
        </div>
    @endif     
    @if (isset($post->iframe))
        <div class="ratio ratio-16x9 mt-3" >
            {!! $post->iframe !!}
        </div>
    @endif         
    
    <div class="card-body">
        <h3 class="card-title mb-3">{{$post->titulo}}</h3>
        {!! $post->descripcion !!}


        @if (isset($post->id_curso))
            <a @if (auth()->user()->role=='admin' || auth()->user()->role=='profesor') href="/curso/{{$post->curso->id}}"
            @elseif(auth()->user()->role=='alumno')  href="/alumno/cursos/{{$post->curso->codigo}}" 
            @endif class="btn btn-outline-primary btn-sm mt-4 rounded-pill">
                {{$post->curso->nombre}}
            </a>
        @endif  
            
            
        <div class="d-flex justify-item-center gap-3 mt-2 pt-2 border-top">
            <div>
                <img src="/storage/fotos_perfil/{{$post->autorimagen}}" style="width:40px;height: 40px;object-fit: cover">
            </div>
            
            <div>
                <p class="fw-bold my-0">{{$post->autor}}</p>
                <p class="card-text"><small class="text-muted">{{$post->fechacreacion}}</small></p>
            </div>
        </div>                       
    </div>
</div>