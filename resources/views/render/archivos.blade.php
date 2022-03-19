<div class="archivos-grid my-3" id="archivos-grid" @if ($post->archivos->count()=='0') style="display: none" @endif >
    @if(isset($cancelar))
        @foreach ($post->archivos->where('estado','!=','eliminar_editar') as $archivo)       
            <x-archivo :archivo="$archivo" tipo="editar"/>
        @endforeach
    @else
        @foreach ($post->archivos->where('estado','publicar') as $archivo)       
            <x-archivo :archivo="$archivo" tipo="editar"/>
        @endforeach
    @endif
    
</div>