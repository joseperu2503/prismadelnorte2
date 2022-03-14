<div class="archivos-grid my-3" id="archivos-grid" @if ($post->archivos->count()=='0') style="display: none" @endif >
    @foreach ($post->archivos as $archivo)       
        <x-archivo :archivo="$archivo" tipo="editar"/>
    @endforeach
</div>