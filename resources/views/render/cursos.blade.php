<select id="id_curso" name="id_curso" class="form-select w-100" form="form">
    <option selected disabled value="">Curso</option>
    @foreach ($cursos as $curso)
        <option value="{{$curso->id}}">{{$curso->nombre}}</option>
    @endforeach                                     
</select>