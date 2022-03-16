<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Post;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
date_default_timezone_set("America/Lima");
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::paginate(5);
        if($request -> ajax()){
            $view = view('data',compact('posts'))->render();
            return response()->json(['html' => $view]);
        }
        return view('post',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //Elimina los posts que no fueron ni publicados ni borrador
        $posts = Post::select('*')->where('estado', 'eliminar')->where('id_user', auth()->user()->id)->get();
        foreach($posts as $post){
            foreach($post->archivos as $archivo){
                $archivo->delete();
            }
            if($post->carpeta != null){
                Storage::disk("google")->deleteDirectory($post->carpeta);
            }
            
            $post->delete();
        }

        //crea un nuevo post en blanco
        $post_crear = Post::create([
            'id_user'=>auth()->user()->id,
            'tarea'=>'1',
            'estado' =>'eliminar'
        ]);
        

        return view('admin.post.create')->with('post',$post_crear); 
    }

    public function create_profesor($id)
    {   
        $curso = Curso::find($id);
        $profesor = Profesor::find($curso->id_profesor);
        return view('admin.post.create')->with('curso',$curso)->with('profesor',$profesor);
 
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
        $datos['estado'] = 'publicar';
        $datos['fecha_hora'] = date("Y-m-d H:i:s");
        //actualiza el post
        $post->update($datos);
     
        //retorna vista
        if(auth()->user()->role=='admin'){
            if($request->id_curso){
                return redirect()->route('curso.perfil',$request->id_curso);   
            }else{
                return redirect()->route('admin.inicio');
            }
            
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('curso.perfil',$request->id_curso);
        }
    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.post.edit')->with('post',$post);
    }

    public function update(Request $request, $id)
    {      
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg'
        ]);
        $datos = $request->all();
        $post = Post::find($id);
        if($imagen = $request->file('imagen')) {         
            $nombre_img = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('imagenes_post',$nombre_img,'public');
            $datos['imagen'] = Storage::url($imagen);
            Storage::delete(str_replace("storage", "public", $post->imagen)); 
        }
        $post->update($datos);


        if(auth()->user()->role=='admin'){
            if($post->id_curso){
                return redirect()->route('curso.perfil',$post->id_curso);   
            }else{
                return redirect()->route('admin.inicio');
            }           
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('curso.perfil',$post->id_curso);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        Storage::delete(str_replace("storage", "public", $post->imagen)); 
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
}
