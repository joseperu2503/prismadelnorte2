<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Aula;
use App\Models\Nota;
use App\Models\Post;
use App\Models\Profesor;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
   
    public function create()
    {    
        $profesores = Profesor::all();
        $aulas = Aula::all();
        return view('admin.cursos.create')->with('aulas',$aulas)->with('profesores',$profesores);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_aula' => 'required',
            'id_profesor' => 'required',
        ]);

        $curso = $request->all();       
        Curso::create($curso);
        return redirect()->route('admin.cursos');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {   
        $profesores = Profesor::all();
        $aulas = Aula::all();
        $curso = Curso::find($id);
        return view('admin.cursos.edit')->with('curso',$curso)->with('aulas',$aulas)->with('profesores',$profesores);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_aula' => 'required',
            'id_profesor' => 'required',
        ]);

        $curso = Curso::find($id);
        $curso->update($request->all());
        return redirect()->route('admin.cursos');
    }

    public function destroy($id)
    {
        $curso = Curso::find($id);
        $curso->delete();
        return redirect()->route('admin.cursos');
    }

    public function perfil(Request $request, $id)
    {   
        $curso = Curso::find($id);
        $id_profesor = Curso::select('*')           
            ->where('id_profesor', $curso->id_profesor)
            ->first()->id_profesor;
        $profesor = Profesor::select('*')           
            ->where('id', $id_profesor)
            ->first();
        $aula = Aula::select('*')           
            ->where('id', $curso->id_aula)
            ->first();    
        $bimestres = Nota::select('bimestres.bimestre','bimestres.id')   
            ->leftjoin('bimestres', 'notas.id_bimestre', '=', 'bimestres.id')        
            ->where('id_curso', $id)
            ->distinct()
            ->get();
        $alumnos = Alumno::select('*') 
            ->where('id_aula', $aula->id)
            ->orderBy('apellido_paterno', 'asc')
            ->get();
        $evaluaciones = Nota::select('evaluacions.evaluacion','notas.num_evaluacion','notas.id_evaluacion','notas.id_bimestre')   
            ->leftjoin('evaluacions', 'notas.id_evaluacion', '=', 'evaluacions.id')        
            ->where('id_curso', $id)
            ->orderBy('id_bimestre', 'asc')
            ->orderBy('id_evaluacion', 'asc')
            ->orderBy('num_evaluacion', 'asc')
            ->distinct()
            ->get();
                      
        $notas_tabla = [];
        foreach($bimestres as $bimestre){
            $notas_bimestre = [];        
            foreach($alumnos as $alumno){
                $notas_alumno = [];              
                foreach($evaluaciones as $evaluacion){   
                    if($evaluacion->id_bimestre == $bimestre->id){
                        $nota = DB::table('notas')                  
                        ->where('id_curso', $id)
                        ->where('id_alumno', $alumno->id)
                        ->where('id_bimestre', $bimestre->id)
                        ->where('id_evaluacion', $evaluacion->id_evaluacion)
                        ->where('num_evaluacion', $evaluacion->num_evaluacion)
                        ->first();    
                        if(isset($nota)) {
                            $nota2=$nota->nota;
                        }else{
                            $nota2='NSP';
                        }
                        $notas_alumno += ["$evaluacion->id_evaluacion $evaluacion->num_evaluacion" => $nota2];  
                    }                             
                }
                $notas_bimestre += [$alumno->id => $notas_alumno];
            }

            $notas_tabla += [$bimestre->id => $notas_bimestre];           
        }

        $posts = Post::with(['user','curso.aula'])
            ->where('id_curso',$id)     
            ->orderby('created_at','desc')
            ->paginate(5);

        if($request->ajax()){
            $view = view('admin.posts',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }   




        return view('admin.cursos.perfil.index')
            ->with('curso',$curso)
            ->with('profesor',$profesor)
            ->with('aula',$aula)
            ->with('bimestres',$bimestres)
            ->with('alumnos',$alumnos)
            ->with('evaluaciones',$evaluaciones)
            ->with('posts',$posts)
            ->with('notas_tabla',$notas_tabla);



            // $curso = Curso::find($id);
            // $id_profesor = Curso::select('*')           
            //     ->where('id_profesor', $curso->id_profesor)
            //     ->first()->id_profesor;
            // $profesor = Profesor::select('*')           
            //     ->where('id', $id_profesor)
            //     ->first();
            // $aula = Aula::select('*')           
            //     ->where('id', $curso->id_aula)
            //     ->first();    
            // $bimestres = Nota::select('bimestres.bimestre','bimestres.id')   
            //     ->leftjoin('bimestres', 'notas.id_bimestre', '=', 'bimestres.id')        
            //     ->where('id_curso', $id)
            //     ->distinct()
            //     ->get();
            // $alumnos = Alumno::select('*') 
            //     ->where('id_aula', $aula->id)
            //     ->orderBy('apellido_paterno', 'asc')
            //     ->get();
            // $evaluaciones = Nota::select('evaluacions.evaluacion','notas.num_evaluacion','notas.id_evaluacion','notas.id_bimestre')   
            //     ->leftjoin('evaluacions', 'notas.id_evaluacion', '=', 'evaluacions.id')        
            //     ->where('id_curso', $id)
            //     ->distinct()
            //     ->get();
            
    
            // $prueba=[];
            // foreach($alumnos as $alumno){
            //     $notas_alumno = ["hola"=>"soy"];
            //     $prueba += [$alumno->id => $notas_alumno];
               
            // }
    
            // $notas_tabla = [];
            // foreach($bimestres as $bimestre){
            //     $notas_bimestre = [];        
            //     foreach($alumnos as $alumno){
            //         $notas_alumno = [];              
            //         foreach($evaluaciones as $evaluacion){   
            //             if($evaluacion->id_bimestre == $bimestre->id){
            //                 $nota = DB::table('notas')                  
            //                 ->where('id_curso', $id)
            //                 ->where('id_alumno', $alumno->id)
            //                 ->where('id_bimestre', $bimestre->id)
            //                 ->where('id_evaluacion', $evaluacion->id_evaluacion)
            //                 ->where('num_evaluacion', $evaluacion->num_evaluacion)
            //                 ->first();       
            //                 $notas_alumno += ["$evaluacion->id_evaluacion $evaluacion->num_evaluacion" => $nota->nota];  
            //             }                             
            //         }
            //         $notas_bimestre += [$alumno->id => $notas_alumno];
            //     }
            //     $notas_tabla += [$bimestre->id => $notas_bimestre];           
            // }
            
            // return view('admin.curso.perfil.index')
            //     ->with('curso',$curso)
            //     ->with('profesor',$profesor)
            //     ->with('aula',$aula)
            //     ->with('bimestres',$bimestres)
            //     ->with('alumnos',$alumnos)
            //     ->with('evaluaciones',$evaluaciones)
            //     ->with('notas_tabla',$notas_tabla);
        
    }

}
