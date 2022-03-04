<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Aula;
use App\Models\Alumno;
use App\Models\Bimestre;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Evaluacion;
use App\Models\Genero;
use App\Models\Grado;
use App\Models\Nivel;
use App\Models\niveles;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $genero = new Genero();
        $genero->genero = 'Masculino';
        $genero->save();

        $genero = new Genero();
        $genero->genero = 'Femenino';
        $genero->save();

        $grado = new Grado();
        $grado->grado = '3 años';
        $grado->save();

        $grado = new Grado();
        $grado->grado = '4 años';
        $grado->save();

        $grado = new Grado();
        $grado->grado = '5 años';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Primer Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Segundo Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Tercer Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Cuarto Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Quinto Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Sexto Grado de Primaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Primer Año de Secundaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Segundo Año de Secundaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Tercer Año de Secundaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Cuarto Año de Secundaria';
        $grado->save();

        $grado = new Grado();
        $grado->grado = 'Quinto Año de Secundaria';
        $grado->save();



        $user = new User;
        $user->dni = '74706220';
        $user->password = 'pegi';
        $user->role = 'admin';
        $user->save();

        $nivel = new Nivel();
        $nivel->nivel = 'Inicial';
        $nivel->save();

        $nivel = new Nivel();
        $nivel->nivel = 'Primaria';
        $nivel->save();

        $nivel = new Nivel();
        $nivel->nivel = 'Secundaria';
        $nivel->save();

        $aula = new Aula;
        $aula->codigo = 'PREKINDER';
        $aula->aula = 'Pre-Kinder';
        $aula->id_nivel = '1';
        $aula->abreviatura = 'Pre-Kinder';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = 'KINDER';
        $aula->aula = 'Kinder';
        $aula->id_nivel = '1';
        $aula->abreviatura = 'Kinder';

        $aula->save();


        $aula = new Aula;
        $aula->codigo = '01PRIM';
        $aula->aula = 'Primer Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '1° Primaria';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = '02PRIM';
        $aula->aula = 'Segundo Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '2° Primaria';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = '03PRIM';
        $aula->aula = 'Tercer Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '3° Primaria';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = '04PRIM';
        $aula->aula = 'Cuarto Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '4° Primaria';

        $aula->save();
        $aula = new Aula;
        $aula->codigo = '05PRIM';
        $aula->aula = 'Quinto Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '5° Primaria';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = '06PRIM';
        $aula->aula = 'Sexto Grado de Primaria';
        $aula->id_nivel = '2';
        $aula->abreviatura = '6° Primaria';

        $aula->save();
        $aula = new Aula;
        $aula->codigo = 'BASICO';
        $aula->aula = 'Básico';
        $aula->id_nivel = '3';
        $aula->abreviatura = 'Básico';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = 'INTERMEDIO';
        $aula->aula = 'Intermedio';
        $aula->id_nivel = '3';
        $aula->abreviatura = 'Intermedio';

        $aula->save();

        $aula = new Aula;
        $aula->codigo = 'PRE';
        $aula->aula = 'Pre';
        $aula->id_nivel = '3';
        $aula->abreviatura = 'Pre';

        $aula->save();

        $bimestre = new Bimestre;
        $bimestre->num_bimestre = '1';
        $bimestre->bimestre = 'Primer';
        $bimestre->num_ingles = 'One';
        $bimestre->save();

        $bimestre = new Bimestre;
        $bimestre->num_bimestre = '2';
        $bimestre->bimestre = 'Segundo';
        $bimestre->num_ingles = 'Two';
        $bimestre->save();

        $bimestre = new Bimestre;
        $bimestre->num_bimestre = '3';
        $bimestre->bimestre = 'Tercer';
        $bimestre->num_ingles = 'Three';
        $bimestre->save();

        $bimestre = new Bimestre;
        $bimestre->num_bimestre = '4';
        $bimestre->bimestre = 'Cuarto';
        $bimestre->num_ingles = 'Four';
        $bimestre->save();

        $evaluacion = new Evaluacion;
        $evaluacion->evaluacion = 'Práctica';
        $evaluacion->save();

        $evaluacion = new Evaluacion;
        $evaluacion->evaluacion = 'Exámen Mensual';
        $evaluacion->save();

        $evaluacion = new Evaluacion;
        $evaluacion->evaluacion = 'Exámen Bimestral';
        $evaluacion->save();




        // $alumno = new Alumno;
        // $alumno->dni = '73917269';
        // $alumno->primer_nombre = 'Rousvel';
        // $alumno->segundo_nombre = 'Roldan';
        // $alumno->apellido_paterno = 'Flores';
        // $alumno->apellido_materno = 'Roldan';
        // $alumno->fecha_nacimiento = Carbon::parse('20-11-2009');
        // $alumno->departamento = 'Lima';
        // $alumno->provincia = 'Lima';
        // $alumno->distrito = 'Puente Piedra';
        // $alumno->religion = 'Cristiana';
        // $alumno->discapacidad = 'No';
        // $alumno->id_grado = '9';
        // $alumno->id_aula = '8';
        // $alumno->telefono = '956770895';
        // $alumno->email = 'rousvelr20@gmail.com';
        // $alumno->direccion = 'al costado de la panaderia';
        // $alumno->foto_perfil = '/storage/fotos_perfil/estudiante.png';
        // $alumno->id_genero = '1';
        // $alumno->password = 'hola';
        // $alumno->nombre_padre = 'JOSE MANUEL FLORES DELGADO';
        // $alumno->dni_padre = '06892202';
        // $alumno->telefono_padre = '969300081';
        // $alumno->nombre_madre = 'Gladys Veronica Roldan Obregón ';
        // $alumno->dni_madre = '33254044';
        // $alumno->telefono_madre = '956770895';
        // $alumno->nombre_apoderado = 'Gladys Veronica Roldan Obregón ';
        // $alumno->dni_apoderado = '33254044';
        // $alumno->telefono_apoderado = '33254044';
        // $alumno->save();

        // $user = new User;
        // $user->dni = '73917269';
        // $user->password = 'hola';
        // $user->role = 'alumno';
        // $user->save();


        // $profesor = new Profesor;
        // $profesor->dni = '45978632';
        // $profesor->primer_nombre = 'Jose';
        // $profesor->segundo_nombre = 'Manuel';
        // $profesor->apellido_paterno = 'Martinez';
        // $profesor->apellido_materno = 'Lopez';
        // $profesor->telefono = '993689145';
        // $profesor->email = 'joseperu2503@gmail.com';
        // $profesor->direccion = 'al costado de la panaderia';
        // $profesor->id_genero = '1';
        // $profesor->foto_perfil = 'man.png';
        // $profesor->password = 'mama';
        // $profesor->save();

        // $user = new User;
        // $user->dni = '45978632';
        // $user->password = 'mama';
        // $user->role = 'profesor';
        // $user->save();

        // $profesor = new Profesor;
        // $profesor->dni = '45978635';
        // $profesor->primer_nombre = 'Gabriela';
        // $profesor->segundo_nombre = 'Lucia';
        // $profesor->apellido_paterno = 'Ortega';
        // $profesor->apellido_materno = 'Tarazona';
        // $profesor->telefono = '993689145';
        // $profesor->email = 'joseperu2503@gmail.com';
        // $profesor->direccion = 'al costado de la panaderia';
        // $profesor->id_genero = '2';
        // $profesor->foto_perfil = 'man.png';
        // $profesor->password = 'mama';
        // $profesor->save();

        // $user = new User;
        // $user->dni = '45978635';
        // $user->password = 'mama';
        // $user->role = 'profesor';
        // $user->save();

        // $curso = new Curso;
        // $curso->codigo = 'ARIT06PRIM';
        // $curso->nombre = 'aritmetica';
        // $curso->id_profesor = '1';
        // $curso->id_aula = '8';
        // $curso->save();

        // $curso = new Curso;
        // $curso->codigo = 'ALGE06PRIM';
        // $curso->nombre = 'algebra';
        // $curso->id_profesor = '1';
        // $curso->id_aula = '8';
        // $curso->save();


        // $curso = new Curso;
        // $curso->codigo = 'GEO05PRIM';
        // $curso->nombre = 'geometria';
        // $curso->id_profesor = '1';
        // $curso->id_aula = '7';
        // $curso->save();


        // $curso = new Curso;
        // $curso->codigo = 'TRIGO05PRIM';
        // $curso->nombre = 'trigonometria';
        // $curso->id_profesor = '1';
        // $curso->id_aula = '7';
        // $curso->save();

        


    }

}
