<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
//use App\Http\Controllers\AulaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\TrabajadorController;
use App\Models\Trabajador;
use Illuminate\Support\Facades\URL;

Route::get('/', function () {
    // return view('login.index');
    return redirect()->route('login.index');
})->middleware('auth');

Route::get('/login', [SessionsController::class,'create'])
    ->middleware('guest')
    ->name('login.index');
Route::post('/login', [SessionsController::class,'store'])
->name('login.store');
Route::get('/logout', [SessionsController::class,'destroy'])
    ->middleware('auth')
    ->name('login.destroy');


Route::get('/register', [RegisterController::class,'create'])
    ->middleware('guest')
    ->name('register.index');
Route::post('/register', [RegisterController::class,'store'])
    ->name('register.store');

Route::get('/admin', [AdminController::class,'index'])
    ->middleware('auth.admin')
    ->name('admin.index');

Route::resource('aulas',AulaController::class)
    ->middleware('auth.admin');


// Cursos
Route::resource('cursos',CursoController::class);
Route::get('/curso/{id}', [CursoController::class,'perfil'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('curso.perfil');

// Notas
Route::get('/curso/{id}/agregar_notas', [NotaController::class,'create'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('nota.create');
Route::put('/curso/{id}/store', [NotaController::class,'store'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('nota.store');

Route::get('/curso/{id_curso}/{id_bimestre}/{id_evaluacion}/{num_evaluacion}/editar_nota', [NotaController::class,'edit'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('nota.edit');

Route::put('/curso/{id}/update', [NotaController::class,'update'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('nota.update');

Route::put('/notas/destroy', [NotaController::class,'destroy'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('nota.destroy');

//Profesores

Route::resource('profesores','App\Http\Controllers\ProfesorController')
    ->middleware('auth.admin');
Route::get('/profesor/{id}', [ProfesorController::class,'perfil'])
    ->middleware('auth.admin')
    ->name('profesor.perfil');
Route::get('/profesor/{id}/cursos', [ProfesorController::class,'cursos'])
    ->middleware('auth.admin')
    ->name('profesor.cursos');

// Profesor usuario
Route::get('/profesor', [ProfesorController::class,'index_usuario'])
    ->middleware('auth.profesor')
    ->name('profesor.usuario.index');
Route::get('mis_cursos', [ProfesorController::class,'cursos_usuario'])
    ->middleware('auth.profesor')
    ->name('profesor.mis_cursos');
    

//Alumno admin
Route::get('alumnos/{aula_id}', [AlumnoController::class,'index'])
    ->middleware('auth.admin')
    ->name('alumno.index');

Route::resource('alumnos',AlumnoController::class)
    ->middleware('auth.admin');
Route::get('/alumnos/{id}/create', [AlumnoController::class,'create'])
    ->middleware('auth.admin')
    ->name('alumno.create');



// Alumno usuario
Route::get('/alumno', [AlumnoController::class,'index_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.usuario.index');    

Route::get('/alumno/perfil', [AlumnoController::class,'perfil_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.usuario.perfil');

Route::put('/alumno/{id}/actualizar_foto', [AlumnoController::class,'update_foto'])
    ->middleware('auth.estudiante')
    ->name('alumno.usuario.update_foto');

Route::get('/alumno/cursos', [AlumnoController::class,'cursos_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.usuario.cursos');

Route::get('/alumno/cursos/{codigo_curso}', [AlumnoController::class,'curso_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.usuario.curso');

Route::get('/alumno/mi_asistencia', [AlumnoController::class,'asistencia_usuario'])
    ->middleware('auth.estudiante') 
    ->name('alumno.usuario.asistencia');  

//Asistencia

Route::get('/asistencia_alumnos', [AsistenciaController::class,'index_alumnos'])
    ->middleware('auth.admin') 
    ->name('asistencia.index_alumnos');

Route::get('/asistencia_profesores', [AsistenciaController::class,'index_profesores'])
    ->middleware('auth.admin') 
    ->name('asistencia.index_profesores');

Route::get('/asistencia_trabajadores', [AsistenciaController::class,'index_trabajadores'])
    ->middleware('auth.admin') 
    ->name('asistencia.index_trabajadores');

Route::get('/nueva_asistencia', [AsistenciaController::class,'create'])
    ->middleware('auth.admin') 
    ->name('asistencia.create');

Route::put('/agregando_asistencia', [AsistenciaController::class,'store'])
    ->middleware('auth.admin') 
    ->name('asistencia.store');

//Trabajadores

Route::resource('trabajadores',TrabajadorController::class)
    ->middleware('auth.admin');

//Posts
Route::get('inicio', [PostController::class,'index'])
    ->middleware('auth.admin')
    ->name('inicio.index');

Route::resource('publicaciones',PostController::class)
    ->middleware('auth.profesor');


Route::get('/curso/{id}/crear_publicacion', [PostController::class,'create_profesor'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('post.profesor.create');