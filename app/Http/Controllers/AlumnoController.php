<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\Bimestre;
use App\Models\Genero;
use App\Models\Grado;
use App\Models\Nota;
use App\Models\Post;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
date_default_timezone_set("America/Lima");

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with(['grado','aula'])->get();
        return view('admin.alumnos.alumnos_todos')->with('alumnos',$alumnos);
    }

    public function createTodos()
    {   
        $grados = Grado::all();
        $aulas = Aula::all();
        $generos = Genero::all();
        return view('admin.alumnos.create')->with('aulas',$aulas)->with('grados',$grados)->with('generos',$generos);
    }


    public function create($id)
    {   
        $aula = Aula::find($id);
        $grados = Grado::all();
        $generos = Genero::all();
        return view('admin.alumnos.create')->with('aula',$aula)->with('grados',$grados)->with('generos',$generos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'dni_padre' => 'nullable|numeric|digits:8',
            'dni_madre' => 'nullable|numeric|digits:8',
            'dni_apoderado' => 'nullable|numeric|digits:8',
            'primer_nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required|date',
            'id_aula' => 'required',
            'id_grado' => 'required',
            'id_genero' => 'required',
            'password' => 'required|alpha|max:4'
        ]);

        if(User::where("dni",$request->get('dni'))->first()){
            return redirect()->route('alumno.create',$request->get('id_aula'))->withErrors(
                ['message' =>'El dni ingresado ya está registrado en el sistema.']
            )->withInput();         
        }
        else{
            Alumno::create([
                'foto_perfil' => '/storage/fotos_perfil/estudiante.png'
            ]+$request->all());
        

            $user = new User();
            $user->dni = $request->get('dni');
            $user->password = $request->get('password');
            $user->role = 'alumno';
            $user->save();
            
            if($request->get('return_aula')){
                return redirect()->route('admin.alumnos',$request->get('id_aula'));
            }else{
                return redirect()->route('alumnos.index');
            }
            
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $alumno = Alumno::find($id);
        $aulas = Aula::all();
        $grados = Grado::all();
        $generos = Genero::all();
        return view('admin.alumnos.edit')->with('alumno',$alumno)->with('aulas',$aulas)->with('grados',$grados)->with('generos',$generos);      
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'dni_padre' => 'nullable|numeric|digits:8',
            'dni_madre' => 'nullable|numeric|digits:8',
            'dni_apoderado' => 'nullable|numeric|digits:8',
            'primer_nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'id_aula' => 'required',
            'id_grado' => 'required',
            'id_genero' => 'required'
        ]);
        
        $alumno = Alumno::find($id);
       
        if($request->get('password')!='' || $request->get('dni') != $alumno->dni){
            $user = User::select('*')->where('dni', $alumno->dni)->first();
            if($request->get('dni') != $alumno->dni){
                $user->dni = $request->get('dni') ;
            }          
            if($request->get('password')!=''){
                $user->password = $request->get('password') ;
            }
            $user->save();
        }
        $alumno->update($request->all());
        return redirect()->route('admin.alumnos',$request->get('id_aula'));
    }

    public function destroy($id)
    {
        $alumno = Alumno::find($id);
        $user = User::select('*')->where('dni', $alumno->dni)->first();
        $user->delete();
        $alumno->delete();
        return redirect()->route('admin.alumnos',$alumno->id_aula);
    }





    public function inicio(Request $request)
    {
        $alumno = Alumno::where('dni', auth()->user()->dni)->first();
        $id_aula=$alumno->id_aula;
        $posts = Post::with(['user','curso.aula'])
            ->whereHas('curso.aula', function ($query)use( $id_aula){
                $query->where('id', $id_aula);
            })
            ->orWhereHas('user', function ($query){
                    $query->where('role', 'admin')              
                      ->whereNull('id_curso');
            })          
            ->orderby('created_at','desc')
            ->paginate(5);

        if($request->ajax()){
            $view = view('alumno.posts',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
        
        return view('alumno.inicio.index')->with('alumno',$alumno)->with('posts',$posts);
    }

    public function perfil_usuario()
    {   
        $dni = auth()->user()->dni;
        $alumno = DB::table('alumnos')->where('dni', $dni)->first();
        $id_aula = $alumno->id_aula;
        $aula = DB::table('aulas')->where('id', $id_aula)->first();
        return view('alumno.perfil')->with('alumno',$alumno)->with('aula',$aula);
    }

    public function update_foto(Request $request,$id)
    {   

        $request->validate([
            'foto_perfil' => 'image|mimes:jpeg,png,jpg'
        ]);
        $alumno = Alumno::find($id);
        if($imagen = $request->file('foto_perfil')) {         
            $nombre_img = date('YmdHis'). "." . $request->file('foto_perfil')->getClientOriginalExtension();
            $imagen = $request->file('foto_perfil')->storeAs('fotos_perfil',$nombre_img,'public');
            $datos['foto_perfil'] = Storage::url($imagen);
            if($alumno->foto_perfil != '/storage/fotos_perfil/estudiante.png'){
                Storage::delete(str_replace("storage", "public", $alumno->foto_perfil)); 
            }
            $alumno->update($datos);         
        }
        return redirect()->route('alumno.perfil');
                  
    }

    public function cursos_usuario()
    {   
        $dni = auth()->user()->dni;
        $alumno = DB::table('alumnos')->where('dni', $dni)->first();
        $id_aula = $alumno->id_aula;
        $cursos = DB::table('cursos')->where('id_aula', $id_aula)->get();
        return view('alumno.cursos')->with('cursos',$cursos)->with('alumno',$alumno);
    }

    public function curso_usuario(Request $request, $codigo)
    {   
        $dni = auth()->user()->dni;
        $alumno = DB::table('alumnos')->where('dni', $dni)->first();
        $curso = DB::table('cursos')->where('codigo', $codigo)->first();
        $bimestres = Bimestre::select('*')                      
            ->get();

        $evaluaciones = Nota::select('evaluacions.evaluacion','notas.num_evaluacion','notas.id_evaluacion','notas.id_bimestre')   
            ->leftjoin('evaluacions', 'notas.id_evaluacion', '=', 'evaluacions.id')        
            ->where('id_curso', $curso->id)
            ->distinct()
            ->get();

        $notas_tabla = [];
        foreach($bimestres as $bimestre){
            $notas_bimestre = [];          
                foreach($evaluaciones as $evaluacion){   
                    if($evaluacion->id_bimestre == $bimestre->id){
                        $nota = DB::table('notas')                  
                        ->where('id_curso', $curso->id)
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
                        $notas_bimestre += ["$evaluacion->id_evaluacion $evaluacion->num_evaluacion" => $nota2];  
                    }                             
                }
            $notas_tabla += [$bimestre->id => $notas_bimestre];           
        }

        $posts = Post::with(['user','curso.aula'])
            ->where('id_curso',$curso->id)     
            ->orderby('created_at','desc')
            ->paginate(5);

        if($request->ajax()){
            $view = view('alumno.posts',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }   



        return view('alumno.curso')
            ->with('curso',$curso)
            ->with('alumno',$alumno)
            ->with('bimestres',$bimestres)
            ->with('notas_tabla',$notas_tabla)
            ->with('evaluaciones',$evaluaciones)
            ->with('posts',$posts);
    }

    public function asistencia()
    {   
        $dni = auth()->user()->dni;
        $alumno = DB::table('alumnos')->where('dni', $dni)->first();
        $asistencias = Asistencia::select('*')                  
            ->where('dni',  $dni)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('alumno.asistencia')->with('asistencias',$asistencias)->with('alumno',$alumno);
    }
    
}
