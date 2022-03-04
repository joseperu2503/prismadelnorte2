<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Nivel;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $aulas = Aula::all();
        return view('admin.aula.index')->with('aulas',$aulas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $niveles = Nivel::all();
        return view('admin.aula.create')->with('niveles',$niveles);
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
            'codigo' => 'required',
            'aula' => 'required',
            'id_nivel' => 'required',
            'abreviatura' => 'required',
        ]);
        
        $aula = $request->all();       
        Aula::create($aula);
        return redirect()->route('aulas.index');
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
        $aula = Aula::find($id);
        $niveles = Nivel::all();
        return view('admin.aula.edit')->with('aula',$aula)->with('niveles',$niveles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'codigo' => 'required',
            'aula' => 'required',
            'id_nivel' => 'required',
            'abreviatura' => 'required',
        ]);
        
        $aula_datos = $request->all();
        $aula->update($aula_datos);
        return redirect()->route('aulas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('aulas.index');
    }

    public function alumnos($id)
    {
        $aula = Aula::find($id);
        return view('admin.alumno.index')->with('aula',$aula);
    }
}
