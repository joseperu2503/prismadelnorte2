<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Nivel;
date_default_timezone_set("America/Lima");
class AulaController extends Controller
{
   
    public function create()
    {   
        $niveles = Nivel::all();
        return view('admin.aulas.create')->with('niveles',$niveles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'aula' => 'required',
            'id_nivel' => 'required',
            'abreviatura' => 'required',
        ]);
        
        $aula = $request->all();       
        Aula::create($aula);
        return redirect()->route('admin.aulas');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $aula = Aula::find($id);
        $niveles = Nivel::all();
        return view('admin.aulas.edit')->with('aula',$aula)->with('niveles',$niveles);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required',
            'aula' => 'required',
            'id_nivel' => 'required',
            'abreviatura' => 'required',
        ]);
        $aula = Aula::find($id);
        $aula->update($request->all());
        return redirect()->route('admin.aulas');
    }

    public function destroy($id)
    {
        $aula = Aula::find($id);
        $aula->delete();
        return redirect()->route('admin.aulas');
    }

    public function alumnos($id)
    {
        $aula = Aula::find($id);
        return view('admin.alumno.index')->with('aula',$aula);
    }
}
