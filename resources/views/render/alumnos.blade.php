<div class="dropdown">
    <button class="form-select alumnos-boton" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="width:250px;text-align:left">
        Todos los alumnos
    </button>
    <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1" style="width: max-content">
        <div class="form-check">
            <input class="form-check-input todos-alumnos" name="alumnos[]" type="checkbox" value="0" id="flexCheckDefault" placeholder="Todos los alumnos" form="form" checked>
            <label>
                Todos los alumnos
            </label>
        </div>
        @foreach ($alumnos as $alumno)                               
        <div class="form-check">
            <input class="form-check-input alumno-check" name="alumnos[]" type="checkbox" value="{{$alumno->id}}" id="flexCheckDefault"  form="form" checked>
            <label>
                {{$alumno->apellido_paterno}} {{$alumno->primer_nombre}} 
            </label>
        </div>
        @endforeach 
    </div>
</div>