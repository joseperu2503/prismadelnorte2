@foreach ($asistencias as $asistencia)
    <tr>
        <td class="align-middle">{{$asistencia->apellido_paterno}} {{$asistencia->apellido_materno}} {{$asistencia->primer_nombre}} {{$asistencia->segundo_nombre}}</td>
        <td class="align-middle">{{$asistencia->user->role}}</td>
        <td class="align-middle">{{$asistencia->created_at->format('H:i:s')}}</td>
        <td class="align-middle">{{$asistencia->estado}}</td>
    </tr>
@endforeach