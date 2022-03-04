@extends('layouts.appAlumno')

@section('title','Asistencia')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection
@section('content')

    <h1 class="titulo">Asistencia</h1>

    <div class="table-responsive">
        <table id="table_id" class = "table table-hover">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asistencias as $asistencia)
                <tr>
                    <td class="align-middle">{{$asistencia->created_at->format('d/m/Y')}}</td>
                    <td class="align-middle">{{$asistencia->created_at->format('H:i:s')}}</td>
                    <td class="align-middle">
                        @if ($asistencia->estado == 'puntual')
                            <p class = "puntual">{{$asistencia->estado}}</p>
                        @else
                            <p class = "tardanza">{{$asistencia->estado}}</p>
                        @endif
                    </td>
                </tr>
                @endforeach   
            </tbody>
        </table>
    </div>
@endsection