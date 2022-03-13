

<div class="comentario-header mb-3 mt-2" id="comentario-header">
    @if ($post->comentarios->count()=='1')
    {{$post->comentarios->count()}} Comentario
    @else
    {{$post->comentarios->count()}} Comentarios
    @endif           
</div>        
<div class="comentario-body" id="comentario-body">
    @foreach ($post->comentarios as $comentario)
        <x-comentario :comentario="$comentario"/>
    @endforeach            
</div>