<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class EstudianteController extends Controller
{
    // public function index(){
    //     $dni = auth()->user()->dni;
    //     $alumno = DB::table('alumnos')->where('dni', $dni)->first();
    //     return view('estudiante.index')->with('alumno',$alumno);
    // }
    
    // public function cursos()
    // {   
    //     $dni = auth()->user()->dni;
    //     $alumno = DB::table('alumnos')->where('dni', $dni)->first();
    //     $id_aula = $alumno->id_aula;
    //     $cursos = DB::table('cursos')->where('id_aula', $id_aula)->get();
    //     return view('estudiante.cursos')->with('cursos',$cursos)->with('alumno',$alumno);
    // }

    // public function perfil()
    // {   
    //     $dni = auth()->user()->dni;
    //     $alumno = DB::table('alumnos')->where('dni', $dni)->first();
    //     $id_aula = $alumno->id_aula;
    //     $aula = DB::table('aulas')->where('id', $id_aula)->first();
    //     return view('estudiante.perfil')->with('alumno',$alumno)->with('aula',$aula);
    // }

    // public function update(Request $request,$id)
    // {   
    //     $dni = auth()->user()->dni;
    //     $alumno = DB::table('alumnos')->where('dni', $dni)->first();
    //     $id_aula = $alumno->id_aula;
    //     $aula = DB::table('aulas')->where('id', $id_aula)->first();

    //     if($imagen = $request->file('foto_perfil')){
        
    //         $rutaGuardarImg = 'storage/fotos_perfil/';
    //         $imagenAlumno = $imagen->getClientOriginalName(); 
    //         $imagen->move($rutaGuardarImg, $imagenAlumno);
    //         $alum = Alumno::find($id);
    //         $alum->foto_perfil = $imagenAlumno ;
    //         $alum->save();
        
    //         return redirect()->route('estudiante.perfil');
    //     }else{
    //         return redirect()->route('estudiante.perfil');
    //     }           
    // }
    
}