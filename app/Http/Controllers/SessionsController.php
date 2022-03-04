<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SessionsController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(){
        if(auth()->attempt(request(['dni', 'password'])) == false){
            return back()->withErrors(
                ['message' =>'El DNI o la contraseña es incorrecta.']
            );
        }else{
            if(auth()->user()->role == 'admin'){
                return redirect()->route('inicio.index');
            }
            else if(auth()->user()->role == 'alumno') {
                $alumno = DB::table('alumnos')->where('dni', auth()->user()->dni)->first();

                if($alumno->id_genero=='1'){
                    return redirect()
                    ->route('alumno.usuario.index')
                    ->with('message', 'Bienvenido '.$alumno->primer_nombre.' '.$alumno->apellido_paterno);
                }else if($alumno->id_genero=='2'){
                    return redirect()
                    ->route('alumno.usuario.index')
                    ->with('message', 'Bienvenida '.$alumno->primer_nombre.' '.$alumno->apellido_paterno);
                }
               
            }
            else if(auth()->user()->role == 'profesor'){
                return redirect()->route('profesor.usuario.index');
            }
            else {
                return redirect()->to('/');
            }
        }
        
    }

    public function destroy(){
        auth()->logout();
        return redirect()->to('/');
    }
}
