<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $post = Post::find($request->get('id_post'));
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
        
        
        
        $archivos = $request->file('archivos');

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
                $archivo = Archivo::create([
                    'id_post'=>$request->get('id_post'),
                    'path'=>end($path),
                    'nombre' => $archivo->getClientOriginalName()
                ]);
            }
            
        } 
   
        $view = view('render.archivos',compact('post'))->render();
        return response()->json([      
            'html'=>$view
        ]);
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
}
