@php
    $imagenes = ['png','jpg','jpeg'];
    $word = ['doc','docx','docm'];
    $excel = ['xls','xlsx','xlsm'];
    $ppt = ['pot','potm','potx','ppam','pps','ppsm','ppsx','ppt','pptm','pptx'];
    
@endphp

<div class="border border-primary rounded-3 archivo-container pe-2">
    <a href="https://drive.google.com/file/d/{{$archivo->path}}/view" class="archivo-enlace" target="_blank">  
        <div class="archivo-icon bg-light fs-1 text-primary border-end border-primary rounded-start px-2">
            @if (in_array(pathinfo($archivo->nombre, PATHINFO_EXTENSION), $imagenes))
                <i class="fas fa-file-image"></i>
            @elseif(pathinfo($archivo->nombre, PATHINFO_EXTENSION)=='pdf')
                <i class="fas fa-file-pdf"></i>
            @elseif(in_array(pathinfo($archivo->nombre, PATHINFO_EXTENSION), $word))
                <i class="fas fa-file-word"></i>
            @elseif(in_array(pathinfo($archivo->nombre, PATHINFO_EXTENSION), $excel))
                <i class="fas fa-file-excel"></i>
            @elseif(in_array(pathinfo($archivo->nombre, PATHINFO_EXTENSION), $ppt))
                <i class="fas fa-file-powerpoint"></i>
            @else
                <i class="fas fa-file"></i>
            @endif
            
        </div>
        <div class="align-items-center ps-3 archivo-nombre" style="overflow:hidden;white-space:nowrap;text-overflow: ellipsis">
            {{$archivo->nombre}}                                       
        </div>
    </a>   
    @if ($tipo == 'editar')
        <button id="eliminar" type="button" class="btn-close" aria-label="Close"></button>
        <form id="eliminar-archivo" method="post">
            @csrf
            <input type="hidden" name="path" value="{{$archivo->path}}">
            <input type="hidden" name="id_post" value="{{$archivo->id_post}}"> 
            <input type="hidden" name="id" value="{{$archivo->id}}">         
        </form>       
    @endif
</div>
