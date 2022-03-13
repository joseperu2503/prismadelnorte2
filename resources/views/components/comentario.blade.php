<div class="mb-3 w-100 comentario comentario-disabled">
    <div style="margin-top: 6.5px">
        <img src="{{$comentario->autorfoto}}" style="width:2rem;height:2rem;object-fit:cover; border-radius:1rem">    
    </div>
    <div style="width: calc(100% - 3rem)" >
        <div class="d-flex justify-content-between" style="height: 24px">
            <div class="d-flex gap-2">
                <p class="fw-bold my-0" style="font-size: 14px">{{$comentario->autor}}</p>
                <p class="card-text  my-0" style="font-size: 14px"><small class="text-muted">{{$comentario->fechacreacion}}</small></p> 
            </div>
            
            <div class="dropdown">
                @if ($comentario->id_user == auth()->user()->id)
                <button class="dropdown-toggle puntos d-none" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                   
                    <li>
                        <form action="{{route('comentarios.destroy',$comentario->id)}}" method="POST" class="dropdown-item">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background:transparent">Eliminar</button>
                        </form>
                    </li>
                </ul>
                @endif
            </div> 
            
        </div>
        <div>
                {{$comentario->descripcion}}        
        </div>       
    </div>
    
</div>