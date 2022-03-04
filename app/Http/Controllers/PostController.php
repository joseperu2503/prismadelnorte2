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
    public function index()
    {
        $posts = Post::select('*')
        ->orderby('created_at','desc')
        ->get();
    
        return view('admin.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.post.create'); 
    }

    public function create_profesor($id)
    {   
        $curso = Curso::find($id);
        $profesor = Profesor::find($curso->id_profesor);
        return view('admin.post.create')->with('curso',$curso)->with('profesor',$profesor);
 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg'
        ]);

        $post=Post::create([
            'id_user' => auth()->user()->id
        ]+$request->all());

        if($request->file('imagen')) {  
            $nombre_img = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('imagenes_post',$nombre_img,'public');
            $post->imagen = Storage::url($imagen);
            $post->save();
        }
        
        if(auth()->user()->role=='admin'){
            if($request->id_curso){
                return redirect()->route('curso.perfil',[$request->id_curso]);   
            }else{
                return redirect()->route('publicaciones.index');
            }
            
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('curso.perfil',[$request->id_curso]);
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
        $post = Post::find($id);
        return view('admin.post.edit')->with('post',$post);
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
                return redirect()->route('curso.perfil',[$post->id_curso]);   
            }else{
                return redirect()->route('publicaciones.index');
            }           
        }
        else if(auth()->user()->role=='profesor'){
            return redirect()->route('curso.perfil',[$post->id_curso]);
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
        return redirect()->route('publicaciones.index');
    }
}
