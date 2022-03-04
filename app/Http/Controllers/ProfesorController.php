<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Genero;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = Profesor::all();
        return view('admin.profesor.index')->with('profesores',$profesores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generos = Genero::all();
        return view('admin.profesor.create')->with('generos',$generos);
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
            'dni' => 'required|numeric|digits:8',
            'primer_nombre' => 'required',
            'segundo_nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'direccion' => 'required',
            'id_genero' => 'required',
            'password' => 'required'
        ]);

        if($request->get('id_genero')=='1'){
            Profesor::create([
                'foto_perfil' => 'man.png'
            ]+$request->all());
        }else if($request->get('id_genero')=='2'){
            Profesor::create([
                'foto_perfil' => 'man.png'
            ]+$request->all());
        }  

        $user = new User();
        $user->dni = $request->get('dni');
        $user->password = $request->get('password');
        $user->role = 'profesor';
        $user->save();

        return redirect()->route('profesores.index');
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
        $profesor = Profesor::find($id);
        $generos = Genero::all();
        return view('admin.profesor.edit')->with('profesor',$profesor)->with('generos',$generos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'primer_nombre' => 'required',
            'segundo_nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'direccion' => 'required',
            'id_genero' => 'required',
        ]);

        $profesor = Profesor::find($id);
        if($request->get('password')!='' || $request->get('dni') != $profesor->dni){
            $user = User::select('*')->where('dni', $profesor->dni)->first();
            if($request->get('dni') != $profesor->dni){
                $user->dni = $request->get('dni') ;
            }          
            if($request->get('password')!=''){
                $user->password = $request->get('password') ;
            }                  
            $user->save();
        }
        if($request->get('id_genero')){
            if($request->get('id_genero')=='1'){
                $profesor->foto_perfil = 'man.png';
            }else if($request->get('id_genero')=='2'){
                $profesor->foto_perfil = 'woman.png';
            } 
        }
        
        $profesor->update($request->all());

        
        return redirect()->route('profesores.index');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profesor = Profesor::find($id);
        $profesor->delete();
        return redirect()->back();
    }

    public function perfil($id)
    {
        $profesor = Profesor::find($id);
        $posts = Post::select('*')
            ->orderby('created_at','desc')
            ->get();
        return view('admin.profesor.perfil.index')->with('profesor',$profesor)->with('posts',$posts);
    }

    public function cursos($id)
    {   
        $profesor = Profesor::find($id);       
        $cursos = Curso::select('*')
            ->where('id_profesor', $profesor->id)
            ->get();

        return view('admin.profesor.perfil.cursos')->with('profesor',$profesor)->with('cursos',$cursos);
    }

    public function index_usuario()
    {
        $profesor = Profesor::where('dni', auth()->user()->dni)->first();
        $posts = Post::select('*')
        ->orderby('created_at','desc')
        ->get();

        return view('admin.profesor.perfil.index')->with('profesor',$profesor)->with('posts',$posts);
    }

    public function cursos_usuario()
    {
        $profesor = Profesor::where('dni', auth()->user()->dni)->first();      
        $cursos = Curso::select('*')
            ->where('id_profesor', $profesor->id)
            ->get();

        return view('admin.profesor.perfil.cursos')->with('profesor',$profesor)->with('cursos',$cursos);
    }

}
