<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\AlumnoPost;
use App\Models\Aula;
use App\Models\Curso;
use App\Models\Post;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
date_default_timezone_set("America/Lima");

function almacenar_post($request, $estado){
    
    
    //return dd($request->get('id_curso'));
    
    //return dd($request->aulas);
    //retorna vista   
};

class PostController extends Controller
{
    
    // public function index(Request $request)
    // {
    //     $posts = Post::paginate(5);
    //     if($request -> ajax()){
    //         $view = view('data',compact('posts'))->render();
    //         return response()->json(['html' => $view]);
    //     }
    //     return view('post',compact('posts'));
    // }

    // public function create()
    // {   
    //     //crea un nuevo post en blanco
    //     $post_crear = Post::create([
    //         'id_user'=>auth()->user()->id,
    //         'tipo'=>'publicacion',
    //         'estado' =>'editando'
    //     ]);
        
    //     $aulas = Aula::select('*')->where('aula',"!=", 'No asignado')->get();
    //     return view('admin.post.create')->with('post',$post_crear)->with('aulas',$aulas); 
    // }

    public function create($tipo)
    {   
        //crea un nuevo post en blanco
        $post_crear = Post::create([
            'id_user'=>auth()->user()->id,
            'tipo'=>$tipo,
            'estado' =>'eliminar'
        ]);
        
        $aulas = Aula::select('*')->where('aula',"!=", 'No asignado')->get();
        return view('admin.post.create')->with('post',$post_crear)->with('aulas',$aulas); 
    }

    public function createPostCurso($id,$tipo)
    {   
        $curso_post = Curso::find($id);
        $alumnos = Alumno::select('*')->where('id_aula',$curso_post->aula->id)->get();
        $post_crear = Post::create([
            'id_user'=>auth()->user()->id,
            'tipo'=>$tipo,
            'estado' =>'eliminar'
        ]);
        $aulas = Aula::select('*')->where('aula',"!=", 'No asignado')->get();
        return view('admin.post.create')->with('post',$post_crear)->with('curso_post',$curso_post)->with('alumnos',$alumnos)->with('aulas',$aulas);
    }

    public function store(Request $request)
    {
        
        //validacion
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg'
        ]);

        //busca el post
        $datos = $request->all();
        $post = Post::find($request->get('id_post'));
        
        //si recibe una imagen de portada la guarda en el servidor y agrega su ubicacion a los datos del post
        if($request->file('imagen')) {  
            $nombre_img = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('imagenes_post',$nombre_img,'public');
            $datos['imagen'] = "/storage/imagenes_post/".$nombre_img;
            
        }
        //establece la hora de publicacion segun el estado del post
        if($request->get('estado')=='publicar'){
            $datos['fecha_publicacion'] = date("Y-m-d H:i:s");
        }elseif($request->get('estado')=='borrador'){
            $datos['fecha_publicacion'] = null;
        }elseif($request->get('estado')=='programar'){
            $datos['fecha_publicacion'] = $request->get('fecha')." ". $request->get('hora');
        }   
        
        //actualiza el post
        $post->update($datos);
        
        //crea los registros alumnospost
        if(count($request->aulas)>1){
            foreach($request->aulas as $aula){
                AlumnoPost::create([
                    'id_post'=>$request->get('id_post'),
                    'id_aula'=>$aula
                ]);
            }
        }else{
            if(in_array('0',$request->alumnos)){
                AlumnoPost::create([
                    'id_post'=>$request->get('id_post'),
                    'id_aula'=>($request->aulas)[0],               
                ]);
            }
            else{
                foreach($request->alumnos as $alumno){
                    AlumnoPost::create([
                        'id_post'=>$request->get('id_post'),
                        'id_aula'=>($request->aulas)[0],
                        'id_curso'=>$request->get('id_curso'),
                        'id_alumno'=>$alumno
                    ]);
                }
            }            
        }


        if(auth()->user()->role=='admin'){
            if($request->id_curso){
                return redirect()->route('admin.curso.perfil',$request->id_curso);   
            }else{
                return redirect()->route('admin.inicio');
            }
            
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('curso.perfil',$request->id_curso);
        }
    }

    public function edit($tipo,$id)
    {
        $aulas_checked = [];
        

        $post = Post::find($id);
        foreach($post->alumnospost as $alumnopost){
            array_push($aulas_checked,$alumnopost->id_aula);
        }

        $numero_aulas = AlumnoPost::select('*')->where('id_post', $id)->distinct('id_aula')->count();
        $aulas = Aula::select('*')->where('aula',"!=", 'No asignado')->get();
        if($numero_aulas=='1'){
            $alumnos_checked = [];
            foreach($post->alumnospost as $alumnopost){
                array_push($alumnos_checked,$alumnopost->id_alumno);
            }
            $aulapost = AlumnoPost::select('*')->where('id_post', $id)->first();
            $alumnos = Alumno::select('*')->where('id_aula', $aulapost->id_aula)->get();
            $cursos = Curso::select('*')->where('id_aula', $aulapost->id_aula)->get();
            return view('admin.post.edit')
            ->with('post',$post)
            ->with('aulas',$aulas)
            ->with('aulas_checked',$aulas_checked)
            ->with('alumnos_checked',$alumnos_checked)
            ->with('alumnos',$alumnos)
            ->with('cursos',$cursos);
        }
           
        return view('admin.post.edit')
            ->with('post',$post)
            ->with('aulas',$aulas)
            ->with('aulas_checked',$aulas_checked);
        
    }

    public function update(Request $request)
    {      
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg'
        ]);

        $datos = $request->all();
        $post = Post::find($request->get('id_post'));
        if($imagen = $request->file('imagen')) {         
            $nombre_img = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('imagenes_post',$nombre_img,'public');
            $datos['imagen'] = Storage::url($imagen);
            Storage::delete(str_replace("storage", "public", $post->imagen)); 
        }


        //establece la hora de publicacion segun el estado del post
        if($request->get('estado')=='publicar' && $post->estado =='publicar'){
            $datos['fecha_publicacion'] = $post->fecha_publicacion;
        }elseif($request->get('estado')=='borrador'){
            $datos['fecha_publicacion'] = null;
        }elseif($request->get('estado')=='programar'){
            $datos['fecha_publicacion'] = $request->get('fecha')." ". $request->get('hora');
        }       
        if($request->get('recibir')==null){
            $datos['recibir'] = 'no';
        }
        if($request->get('id_curso')==null){
            $datos['id_curso'] = null;
        }


        $post->update($datos);


        $post_alumnos = AlumnoPost::select('*')->where('id_post', $request->get('id_post'))->get();
        foreach($post_alumnos as $post_alumno){
            $post_alumno->delete();
        }

        //crea nuevamente los registros en alumno_post
        if(count($request->aulas)>1){
            foreach($request->aulas as $aula){
                AlumnoPost::create([
                    'id_post'=>$request->get('id_post'),
                    'id_aula'=>$aula
                ]);
            }
        }else{
            if(in_array('0',$request->alumnos)){
                AlumnoPost::create([
                    'id_post'=>$request->get('id_post'),
                    'id_aula'=>($request->aulas)[0],               
                ]);
            }
            else{
                foreach($request->alumnos as $alumno){
                    AlumnoPost::create([
                        'id_post'=>$request->get('id_post'),
                        'id_aula'=>($request->aulas)[0],
                        'id_curso'=>$request->get('id_curso'),
                        'id_alumno'=>$alumno
                    ]);
                }
            }            
        }
        foreach($post->archivos as $archivo){
            if($archivo->estado == 'nuevo_editar'){
                $archivo->estado = 'publicar';
                $archivo->save();
            }elseif($archivo->estado == 'eliminar_editar'){
                Storage::disk("google")->delete($archivo->path);
                $archivo->delete();
            }
        }


        if(auth()->user()->role=='admin'){
            if($post->id_curso){
                return redirect()->route('admin.curso.perfil',$post->id_curso);   
            }else{
                return redirect()->route('admin.inicio');
            }           
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('profesor.curso.perfil',$post->id_curso);
        }
    }


    public function destroy($id)
    {
        $post = Post::find($id);

        if($post->imagen != null){
            Storage::delete(str_replace("storage", "public", $post->imagen)); 
        }
        
        $post_alumnos = AlumnoPost::select('*')->where('id_post',$id)->get();
        foreach($post_alumnos as $post_alumno){
            $post_alumno->delete();
        }

        if($post->carpeta != null){
            Storage::disk("google")->deleteDirectory($post->carpeta);
            foreach($post->archivos as $archivo){
                $archivo->delete();
            }
        }

        $post->delete();  

        return redirect()->back();
    }

    public function eliminar_post(Request $request)
    {
        $post = Post::find($request->get('id_post'));
        Storage::delete(str_replace("storage", "public", $post->imagen)); 

        foreach($post->archivos as $archivo){
            $archivo->delete();
        }

        Storage::disk("google")->deleteDirectory($post->carpeta);
        $post->delete();

    }

    public function alumnos(Request $request)
    {   

        $alumnos = Alumno::select('*')->where('id_aula', $request->get('id_aula'))->orderby('apellido_paterno')->get();
        $cursos = Curso::select('*')->where('id_aula', $request->get('id_aula'))->orderby('nombre')->get();
        $view_alumnos = view('render.alumnos')->with('alumnos',$alumnos)->render();
        $view_cursos = view('render.cursos')->with('cursos',$cursos)->render();
        return response()->json([      
            'html1'=>$view_alumnos,
            'html2'=>$view_cursos
        ]);

    }

    public function eliminar_post_crear(Request $request)
    {   
        //Elimina los posts que no fueron ni publicados ni borrador
        $post = Post::select('*')->where('estado', 'eliminar')->where('id',$request->get('id_post'))->first();
        
            foreach($post->archivos as $archivo){
                $archivo->delete();
            }
            if($post->carpeta != null){
                Storage::disk("google")->deleteDirectory($post->carpeta);
            }
            
            $post->delete();
        
        return response()->json([      
            'html1'=>'hola',
        ]);
    }

    public function eliminar_post_editar(Request $request)
    {   
          
        $post = Post::find($request->get('id_post'));
        foreach($post->archivos as $archivo){
            if($archivo->estado == 'nuevo_editar'){
                Storage::disk("google")->delete($archivo->path);
                $archivo->delete();
            }elseif($archivo->estado == 'eliminar_editar'){
                $archivo->estado = 'publicar';
                $archivo->save();
            }
        }
        return response()->json([      
            'html1'=>'hola',
        ]);
    }


}
