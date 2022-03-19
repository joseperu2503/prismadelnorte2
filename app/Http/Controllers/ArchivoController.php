<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {   
        //Busca el post
        $post = Post::find($request->get('id_post'));

        //Si el post no tiene carpeta en drive lo crea
        if( $post->carpeta == null){
            Storage::disk("google")->makeDirectory($request->get('id_post'));
            do{                   
                $carpeta_post = collect(Storage::disk("google")->listContents('/', false))
                ->where('type', '=', 'dir')
                ->where('name', '=', $request->get('id_post'))
                ->first();      
                        
            }while($carpeta_post==null);
            $dir = $carpeta_post['path'];
            $post->carpeta = $dir;
            $post->save();
        }
        
        //archivos recividos
        if($request->file('archivos')){
            $archivos = $request->file('archivos');
        }elseif($request->file('archivos_editar')){
            $archivos = $request->file('archivos_editar');
        }
        

        //almacenar los archivos
        foreach($archivos as $archivo){
            $verficacion = collect(Storage::disk("google")->listContents($post->carpeta, false))
                ->where('type', '=', 'file')
                ->where('name', '=', $archivo->getClientOriginalName())
                ->first();
            if($verficacion == null){
                Storage::disk("google")->putFileAs($post->carpeta,$archivo,$archivo->getClientOriginalName());
                $archivo_drive = collect(Storage::disk("google")->listContents($post->carpeta, false))
                    ->where('type', '=', 'file')
                    ->where('name', '=', $archivo->getClientOriginalName())
                    ->first();
                $path = explode("/", $archivo_drive['path']);
                if($request->file('archivos')){
                    $archivo = Archivo::create([
                        'id_post'=>$request->get('id_post'),
                        'path'=>end($path),
                        'nombre' => $archivo->getClientOriginalName(),                   
                        'estado' => 'publicar'
                    ]);

                }elseif($request->file('archivos_editar')){
                    $archivo = Archivo::create([
                        'id_post'=>$request->get('id_post'),
                        'path'=>end($path),
                        'nombre' => $archivo->getClientOriginalName(),                   
                        'estado' => 'nuevo_editar'
                    ]);

                }
               
            }          
        } 
        $cancelar='1';
        $view = view('render.archivos')->with('post',$post)->with('cancelar',$cancelar)->render();
        return response()->json([      
            'html'=>$view
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        
    }

    public function eliminar_archivo(Request $request)
    {
        
        Storage::disk("google")->delete($request->get('path'));
        $archivo = Archivo::find($request->get('id'));
        $archivo->delete();        
        $post = Post::select('*')->where('id', $request->get('id_post'))->first();   
        $view = view('render.archivos',compact('post'))->render();
        return response()->json([      
            'html'=>$view
        ]);
    }
    public function eliminar_archivo_editar(Request $request)
    {
        
        $archivo = Archivo::find($request->get('id'));
        if($archivo->estado=='nuevo_editar'){
            Storage::disk("google")->delete($archivo->path);
            $archivo->delete();  
        }elseif($archivo->estado=='publicar'){
            $archivo->estado = 'eliminar_editar';
            $archivo->save(); 
        }     
        $post = Post::select('*')->where('id', $request->get('id_post'))->first();  
        $cancelar='1'; 
        $view = view('render.archivos')->with('post',$post)->with('cancelar',$cancelar)->render();
        return response()->json([      
            'html'=>$view
        ]);
    }
}
