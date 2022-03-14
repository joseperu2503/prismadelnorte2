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
        $post_crear = Post::create([
            'id_user'=>auth()->user()->id,
            'tarea'=>'1'
        ]);
        $post = Post::select('*')->where('id', $post_crear->id)->first();  

        return view('admin.post.create')->with('post',$post); 
    }

    public function create_profesor($id)
    {   
        $curso = Curso::find($id);
        $profesor = Profesor::find($curso->id_profesor);
        return view('admin.post.create')->with('curso',$curso)->with('profesor',$profesor);
 
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg'
        ]);

        $datos = $request->all();
        $post = Post::find($request->get('id_post'));
        

        if($request->file('imagen')) {  
            $nombre_img = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('imagenes_post',$nombre_img,'public');
            $post->imagen = Storage::url($imagen);
            
        }

        $post->update($datos);

        //Drive
        if($request->get('id_curso') && $request->hasFile('archivos')){

            $curso=Curso::select('*')
            ->where('id',$request->get('id_curso'))
            ->first();
            
            $contents = collect(Storage::disk("google")->listContents('/', false));
            
            $carpeta_aula = $contents
                ->where('type', '=', 'dir')
                ->where('name', '=', $curso->aula->aula)
                ->first(); 
            
            if(!$carpeta_aula){
                Storage::disk("google")->makeDirectory($curso->aula->aula);
                do{                   
                    $contents = collect(Storage::disk("google")->listContents('/', false));
            
                    $carpeta_aula = $contents
                        ->where('type', '=', 'dir')
                        ->where('name', '=', $curso->aula->aula)
                        ->first();  
                }while($carpeta_aula==null);
            }

            $contents = collect(Storage::disk("google")->listContents($carpeta_aula['path'], false));
            
            $carpeta_curso = $contents
                ->where('type', '=', 'dir')
                ->where('name', '=', $curso->nombre)
                ->first(); 

            if(!$carpeta_curso){
                Storage::disk("google")->makeDirectory($carpeta_aula['path']."/".$curso->nombre);
                do{                   
                    $contents = collect(Storage::disk("google")->listContents($carpeta_aula['path'], false));
            
                    $carpeta_curso = $contents
                        ->where('type', '=', 'dir')
                        ->where('name', '=', $curso->nombre)
                        ->first();  
                }while($carpeta_curso==null);
            }
            Storage::disk("google")->makeDirectory($carpeta_curso['path']."/".$request->titulo);

            do{
                $contents = collect(Storage::disk("google")->listContents($carpeta_curso['path'], false));           
                $carpeta_post = $contents
                    ->where('type', '=', 'dir')
                    ->where('name', '=', $request->titulo)
                    ->first();
            }while($carpeta_post==null);           
            $post->carpeta = $carpeta_post['path'];

            $archivos = $request->file('archivos');
            foreach($archivos as $archivo){ 
                Storage::disk("google")->putFileAs($carpeta_post['path'],$archivo,$archivo->getClientOriginalName());
            } 


        }
       
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
