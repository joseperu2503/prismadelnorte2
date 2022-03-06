<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
   
    public function create()
    {
        return view('admin.trabajador.create');
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
            'direccion' => 'required',
            'puesto' => 'required'
        ]);

        $trabajador = $request->all();       
        Trabajador::create($trabajador);

        $user = new User();
        $user->dni = $request->get('dni');
        $user->password = '1234';
        $user->role = 'trabajador';
        $user->save();


        return redirect()->route('admin.trabajadores');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $trabajador = Trabajador::find($id);
        return view('admin.trabajador.edit')->with('trabajador',$trabajador);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'primer_nombre' => 'required',
            'segundo_nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'puesto' => 'required'
        ]);

        $trabajador = Trabajador::find($id);
        if($request->get('dni') != $trabajador->dni){
            $user = User::select('*')->where('dni', $trabajador->dni)->first();
            if($request->get('dni') != $trabajador->dni){
                $user->dni = $request->get('dni') ;
            }          
            $user->save();
        }
        $trabajador->update($request->all());
        
        return redirect()->route('admin.trabajadores');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trabajador = Trabajador::find($id);
        $trabajador->delete();
        return redirect()->back();
    }
}
