<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
//use App\Http\Controllers\AulaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\ComentarioController;
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



//----------------------------Admin-------------------------

/*inicio*/
Route::get('admin/inicio', [AdminController::class,'inicio'])
    ->middleware('auth.admin')
    ->name('admin.inicio');

/*aulas*/
Route::get('admin/aulas', [AdminController::class,'aulas'])
    ->middleware('auth.admin')
    ->name('admin.aulas');

Route::resource('aula',AulaController::class)
    ->middleware('auth.admin');


/*cursos*/

Route::get('admin/cursos', [AdminController::class,'cursos'])
    ->middleware('auth.admin')
    ->name('admin.cursos');

Route::get('/curso_perfil/{id}', [CursoController::class,'perfil'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('curso.perfil');

Route::resource('curso',CursoController::class)
    ->middleware('auth.admin');

/*profesores*/

Route::get('admin/profesores', [AdminController::class,'profesores'])
    ->middleware('auth.admin')
    ->name('admin.profesores');

Route::resource('profesores',ProfesorController::class)
    ->middleware('auth.admin');

Route::get('/profesor/{id}/inicio', [ProfesorController::class,'perfil'])
    ->middleware('auth.admin')
    ->name('admin.profesor.inicio');
Route::get('/profesor/{id}/cursos', [ProfesorController::class,'cursos'])
    ->middleware('auth.admin')
    ->name('admin.profesor.cursos');

/* Alumnos */

Route::get('alumnos/{aula_id}', [AdminController::class,'alumnos_aula'])
    ->middleware('auth.admin')
    ->name('admin.alumnos');

Route::resource('alumnos',AlumnoController::class)
    ->middleware('auth.admin');

Route::get('/alumno/{id}/create', [AlumnoController::class,'create'])
    ->middleware('auth.admin')
    ->name('alumno.create');

Route::get('/alumno/create', [AlumnoController::class,'createTodos'])
    ->middleware('auth.admin')
    ->name('alumno.createTodos');


/* Trabajadores */

Route::get('admin/trabajadores', [AdminController::class,'trabajadores'])
    ->middleware('auth.admin')
    ->name('admin.trabajadores');

Route::resource('trabajadores',TrabajadorController::class)
    ->middleware('auth.admin');
   
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

Route::post('/agregando_asistencia', [AsistenciaController::class,'store'])
    ->middleware('auth.admin') 
    ->name('asistencia.store');



//Posts

Route::get('/posts',[PostController::class, 'index']);

Route::resource('publicaciones',PostController::class)
    ->middleware('auth.profesor');

Route::post('/archivo/archivo_delete',[PostController::class, 'eliminar_archivo'])
    ->name('post.archivo.delete');

Route::get('/curso/{id}/crear_publicacion', [PostController::class,'create_profesor'])
    ->middleware('auth.profesor') //admin y profesor
    ->name('post.curso.create');

//Comentarios


Route::resource('comentarios',ComentarioController::class);


//----------------------------Alumno-------------------------

Route::get('alumno/inicio', [AlumnoController::class,'inicio'])
    ->middleware('auth.estudiante')
    ->name('alumno.inicio');    

Route::get('/alumno/perfil', [AlumnoController::class,'perfil_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.perfil');

Route::put('/alumno/{id}/actualizar_foto', [AlumnoController::class,'update_foto'])
    ->middleware('auth.estudiante')
    ->name('alumno.update_foto');

Route::get('/alumno/cursos', [AlumnoController::class,'cursos_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.cursos');

Route::get('/alumno/cursos/{codigo_curso}', [AlumnoController::class,'curso_usuario'])
    ->middleware('auth.estudiante')
    ->name('alumno.curso');

Route::get('/alumno/mi_asistencia', [AlumnoController::class,'asistencia'])
    ->middleware('auth.estudiante') 
    ->name('alumno.asistencia');  

//----------------------------Profesor-------------------------

Route::get('profesor/inicio', [ProfesorController::class,'inicio'])
    ->middleware('auth.profesor')
    ->name('profesor.inicio');

Route::get('profesor/cursos', [ProfesorController::class,'cursos_usuario'])
    ->middleware('auth.profesor')
    ->name('profesor.cursos');