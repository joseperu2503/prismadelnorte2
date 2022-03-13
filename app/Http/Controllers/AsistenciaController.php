<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\Profesor;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
date_default_timezone_set("America/Lima");

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistencias = Asistencia::with(['user','user.userrole'])
        ->orderBy('created_at', 'desc')
        ->get();

        // foreach($asistencias as $asistencia){
        //     if($asistencia->role == 'alumno'){
        //         $user_role = Alumno::select('*')->where('dni', $asistencia->dni)->first();                
        //     }else if($asistencia->role == 'profesor'){
        //         $user_role = Profesor::select('*')->where('dni', $asistencia->dni)->first();
        //     }else if($asistencia->role == 'trabajador'){
        //         $user_role = Trabajador::select('*')->where('dni', $asistencia->dni)->first();
        //     }
        //     $asistencia['apellido_paterno'] = $user_role->apellido_paterno;
        //     $asistencia['apellido_materno'] = $user_role->apellido_materno;
        //     $asistencia['primer_nombre'] = $user_role->primer_nombre;
        //     $asistencia['segundo_nombre'] = $user_role->segundo_nombre;
        // }

        return view('admin.asistencia.index')->with('asistencias',$asistencias);
    }

    public function index_alumnos()
    {
        
        $asistencias = Asistencia::select('asistencias.*',
        'alumnos.apellido_paterno','alumnos.apellido_materno',
        'alumnos.primer_nombre','alumnos.segundo_nombre','aulas.aula','users.dni')
        ->leftjoin('users', 'users.id', '=', 'asistencias.id_user')
        ->join('alumnos', 'alumnos.dni', '=', 'users.dni')
        ->leftjoin('aulas', 'aulas.id', '=', 'alumnos.id_aula')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.asistencia.index_alumnos')->with('asistencias',$asistencias);
    }

    public function index_profesores()
    {
        
        $asistencias = Asistencia::select('asistencias.*',
        'profesors.apellido_paterno','profesors.apellido_materno',
        'profesors.primer_nombre','profesors.segundo_nombre','users.dni')
        ->leftjoin('users', 'users.id', '=', 'asistencias.id_user')
        ->join('profesors', 'profesors.dni', '=', 'users.dni')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.asistencia.index_profesores')->with('asistencias',$asistencias);
    }

    public function index_trabajadores()
    {
        
        $asistencias = Asistencia::select('asistencias.*',
        'trabajadors.apellido_paterno','trabajadors.apellido_materno',
        'trabajadors.primer_nombre','trabajadors.segundo_nombre','users.dni')
        ->leftjoin('users', 'users.id', '=', 'asistencias.id_user')
        ->join('trabajadors', 'trabajadors.dni', '=', 'users.dni')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.asistencia.index_trabajadores')->with('asistencias',$asistencias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        date_default_timezone_set("America/Lima");
        $fecha = date("d-m-Y"); 

       
        $asistencias = Asistencia::with(['user'])
        ->whereDate('asistencias.created_at', date("Y-m-d"))
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        foreach($asistencias as $asistencia){
            if($asistencia->user->role == 'alumno'){
                $user_role = Alumno::select('*')->where('dni', $asistencia->user->dni)->first();                
            }else if($asistencia->user->role == 'profesor'){
                $user_role = Profesor::select('*')->where('dni', $asistencia->user->dni)->first();
            }else if($asistencia->user->role == 'trabajador'){
                $user_role = Trabajador::select('*')->where('dni', $asistencia->user->dni)->first();
            }
            $asistencia['apellido_paterno'] = $user_role->apellido_paterno;
            $asistencia['apellido_materno'] = $user_role->apellido_materno;
            $asistencia['primer_nombre'] = $user_role->primer_nombre;
            $asistencia['segundo_nombre'] = $user_role->segundo_nombre;
        }
        return view('admin.asistencia.create')
            ->with('fecha',$fecha)
            ->with('asistencias', $asistencias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        
        
            $hora = strtotime(date("H:i:s"));
            $fecha = date("Y-m-d");

            $user = User::select('*')->where('dni', $request->get('text'))->first();
            if( $user){
                if($user->role == 'alumno'){
                    $user_role = Alumno::select('*')->where('dni', $user->dni)->first();
                }else if($user->role == 'profesor'){
                    $user_role = Profesor::select('*')->where('dni', $user->dni)->first();
                }else if($user->role == 'trabajador'){
                    $user_role = Trabajador::select('*')->where('dni', $user->dni)->first();
                }
        
                $registro = Asistencia::select('*')
                    ->whereDate('created_at', $fecha)
                    ->where('id_user', $user->id)
                    ->count();
                
                if($registro == 0){
                    $hora_puntual = strtotime( "08:00:00" );
                    
                    $asistencia = new Asistencia();
                    $asistencia->id_user = $user->id;
                    $asistencia->tipo = 'entrada';
                    if($hora<$hora_puntual){
                        $asistencia->estado = 'puntual';
                    }
                    else{
                        $asistencia->estado = 'tardanza';
                    }
                    $asistencia->save();

                    $asistencias = Asistencia::with('user')   
                        ->whereDate('asistencias.created_at', date("Y-m-d"))
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    foreach($asistencias as $asistencia){
                        if($asistencia->user->role == 'alumno'){
                            $user_role2 = Alumno::select('*')->where('dni', $asistencia->user->dni)->first();                
                        }else if($asistencia->user->role == 'profesor'){
                            $user_role2 = Profesor::select('*')->where('dni', $asistencia->user->dni)->first();
                        }else if($asistencia->user->role == 'trabajador'){
                            $user_role2 = Trabajador::select('*')->where('dni', $asistencia->user->dni)->first();
                        }
                        $asistencia['apellido_paterno'] = $user_role2->apellido_paterno;
                        $asistencia['apellido_materno'] = $user_role2->apellido_materno;
                        $asistencia['primer_nombre'] = $user_role2->primer_nombre;
                        $asistencia['segundo_nombre'] = $user_role2->segundo_nombre;
                    }
                    $view = view('admin.asistencia.ultimos_registros',compact('asistencias'))->render();
                    return response()->json([
                        'mensaje' =>  'Asistencia de <b>'.$user->user_role->primer_nombre.' '.$user->user_role->apellido_paterno.'</b> registrada exitosamente!',
                        'tipo' =>'success',
                        'html'=>$view,
                    ]);
                        
                }else{
                    return response()->json([
                        'mensaje' =>  'La asistencia de <b>'.$user->user_role->primer_nombre.' '.$user->user_role->apellido_paterno.'</b> ya fué registrada!',
                        'tipo' =>'error'
                    ]);                
                }

            }else{
                return response()->json([
                    'mensaje' =>  'El QR escaneado no está registrado en el sistema!!',
                    'tipo' =>'error'
                ]);                
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
