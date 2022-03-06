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

    public function create()
    {
        $generos = Genero::all();
        return view('admin.profesores.create')->with('generos',$generos);
    }

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

        return redirect()->route('admin.profesores');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $profesor = Profesor::find($id);
        $generos = Genero::all();
        return view('admin.profesores.edit')->with('profesor',$profesor)->with('generos',$generos);
    }

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
        //si cambia de contraseña o dni, debe cambiarse en la tabla user tambien
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
        //si cambia de genero debe cambiar su foto de perfil
        if($request->get('id_genero')){
            if($request->get('id_genero')=='1'){
                $profesor->foto_perfil = 'man.png';
            }else if($request->get('id_genero')=='2'){
                $profesor->foto_perfil = 'woman.png';
            } 
        }
        
        $profesor->update($request->all());

        return redirect()->route('admin.profesores');   
    }

    public function destroy($id)
    {
        $profesor = Profesor::find($id);
        $profesor->delete();
        return redirect()->route('admin.profesores');
    }

    public function perfil($id)
    {
        $profesor = Profesor::find($id);
        $posts = Post::select('*')
            ->orderby('created_at','desc')
            ->get();
        return view('profesor.inicio')->with('profesor',$profesor)->with('posts',$posts);
    }

    public function cursos($id)
    {   
        $profesor = Profesor::find($id);       
        $cursos = Curso::select('*')
            ->where('id_profesor', $profesor->id)
            ->get();

        return view('profesor.cursos')->with('profesor',$profesor)->with('cursos',$cursos);
    }

    public function inicio()
    {
        $profesor = Profesor::where('dni', auth()->user()->dni)->first();
        $posts = Post::select('*')
        ->orderby('created_at','desc')
        ->get();

        return view('profesor.inicio')->with('profesor',$profesor)->with('posts',$posts);
    }

    public function cursos_usuario()
    {
        $profesor = Profesor::where('dni', auth()->user()->dni)->first();      
        $cursos = Curso::select('*')
            ->where('id_profesor', $profesor->id)
            ->get();

        return view('profesor.cursos')->with('profesor',$profesor)->with('cursos',$cursos);
    }

}
