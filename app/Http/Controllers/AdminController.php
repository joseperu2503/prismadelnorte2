<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Post;
use App\Models\Profesor;
use App\Models\Trabajador;
use Illuminate\Http\Request;
date_default_timezone_set("America/Lima");
class AdminController extends Controller
{
    public function inicio(Request $request){
        $posts = Post::with(['comentarios.user','curso','user'])
        ->orderby('created_at','desc')
        ->paginate(5);
        if($request->ajax()){
            $view = view('admin.posts',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('admin.inicio.index')->with('posts',$posts);
    }

    public function Aulas(){
        $aulas = Aula::all();
        return view('admin.aulas.index')->with('aulas',$aulas);
    }

    public function Profesores(){
        $profesores = Profesor::all();
        return view('admin.profesores.index')->with('profesores',$profesores);
    }

    public function Cursos(){
        $cursos = Curso::with(['profesor','aula'])
        ->get();
        return view('admin.cursos.index')->with('cursos',$cursos);
    }

    public function Alumnos_aula($aula_id){
        $aula = Aula::find($aula_id);
        return view('admin.alumnos.alumnos_aula')->with('aula',$aula);
    }

    public function Trabajadores(){
        $trabajadores = Trabajador::all();
        return view('admin.trabajador.index')->with('trabajadores',$trabajadores);
    }




}