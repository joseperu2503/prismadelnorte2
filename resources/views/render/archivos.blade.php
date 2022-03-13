<div class="archivos-grid my-3" id="archivos-grid" style="display: none">
    @foreach ($post->archivos as $archivo)       
        <x-archivo :archivo="$archivo" tipo="editar" :idPost="$post->id"/>
    @endforeach
</div>