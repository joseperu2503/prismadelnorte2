<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
//use App\Http\Controllers\AulaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ArchivoController;
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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', function () {
    // return view('login.index');
    return redirect()->route('login.index');
})->middleware('auth');

Route::get('/login', [SessionsController::class,'create'])->middleware('guest')->name('login.index');
Route::post('/login', [SessionsController::class,'store'])->name('login.store');
Route::get('/logout', [SessionsController::class,'destroy'])->middleware('auth')->name('login.destroy');


Route::get('/register', [RegisterController::class,'create'])->middleware('guest')->name('register.index');
Route::post('/register', [RegisterController::class,'store'])->name('register.store');

//----------------------------Admin-------------------------

// Inicio
Route::get('admin/inicio', [AdminController::class,'inicio'])->middleware('auth.admin')->name('admin.inicio');
//Aulas
Route::get('admin/aulas', [AdminController::class,'aulas'])->middleware('auth.admin')->name('admin.aulas');
Route::get('admin/aula/nuevo', [AulaController::class,'create'])->middleware('auth.admin')->name('admin.aula.create');
Route::post('admin/aula/guardar', [AulaController::class,'store'])->middleware('auth.admin')->name('admin.aula.store');
Route::get('admin/aula/{id}/editar', [AulaController::class,'edit'])->middleware('auth.admin')->name('admin.aula.edit');
Route::put('admin/aula/{id}/actualizar', [AulaController::class,'update'])->middleware('auth.admin')->name('admin.aula.update');
Route::delete('admin/aula/{id}/eliminar', [AulaController::class,'destroy'])->middleware('auth.admin')->name('admin.aula.destroy');

//Cursos

Route::get('admin/cursos', [AdminController::class,'cursos'])->middleware('auth.admin')->name('admin.cursos');
Route::get('admin/curso/nuevo', [CursoController::class,'create'])->middleware('auth.admin')->name('admin.curso.create');
Route::post('admin/curso/guardar', [CursoController::class,'store'])->middleware('auth.admin')->name('admin.curso.store');
Route::get('admin/curso/{id}/editar', [CursoController::class,'edit'])->middleware('auth.admin')->name('admin.curso.edit');
Route::put('admin/curso/{id}/actualizar', [CursoController::class,'update'])->middleware('auth.admin')->name('admin.curso.update');
Route::delete('admin/curso/{id}/eliminar', [CursoController::class,'destroy'])->middleware('auth.admin')->name('admin.curso.destroy');

Route::get('admin/curso/{id}', [CursoController::class,'perfil'])->middleware('auth.admin')->name('admin.curso.perfil');
Route::get('profesor/curso/{id}', [CursoController::class,'perfil'])->middleware('auth.profesor')->name('profesor.curso.perfil');


/*profesores*/

Route::get('admin/profesores', [AdminController::class,'profesores'])->middleware('auth.admin')->name('admin.profesores');
Route::get('admin/profesor/nuevo', [ProfesorController::class,'create'])->middleware('auth.admin')->name('admin.profesor.create');
Route::post('admin/profesor/guardar', [ProfesorController::class,'store'])->middleware('auth.admin')->name('admin.profesor.store');
Route::get('admin/profesor/{id}/editar', [ProfesorController::class,'edit'])->middleware('auth.admin')->name('admin.profesor.edit');
Route::put('admin/profesor/{id}/actualizar', [ProfesorController::class,'update'])->middleware('auth.admin')->name('admin.profesor.update');
Route::delete('admin/profesor/{id}/eliminar', [ProfesorController::class,'destroy'])->middleware('auth.admin')->name('admin.profesor.destroy');


Route::get('admin/profesor/{id}/inicio', [ProfesorController::class,'perfil'])->middleware('auth.admin')->name('admin.profesor.inicio');
Route::get('admin/profesor/{id}/cursos', [ProfesorController::class,'cursos'])->middleware('auth.admin')->name('admin.profesor.cursos');

/* Alumnos */

Route::get('admin/todos_los_alumnos', [AdminController::class,'todosLosAlumnos'])->middleware('auth.admin')->name('admin.alumnos'); 
Route::get('alumnos/{aula_id}', [AdminController::class,'AlumnosPorAula'])->middleware('auth.admin')->name('admin.alumnosPorAula'); 
Route::get('admin/alumno/{id}/nuevo', [AlumnoController::class,'create'])->middleware('auth.admin')->name('admin.alumno.create');  
Route::post('admin/alumno/guardar', [AlumnoController::class,'store'])->middleware('auth.admin')->name('admin.alumno.store');
Route::get('admin/alumno/{id}/editar', [AlumnoController::class,'edit'])->middleware('auth.admin')->name('admin.alumno.edit');
Route::put('admin/alumno/{id}/actualizar', [AlumnoController::class,'update'])->middleware('auth.admin')->name('admin.alumno.update');
Route::delete('admin/alumno/{id}/eliminar', [AlumnoController::class,'destroy'])->middleware('auth.admin')->name('admin.alumno.destroy');
    
/* Trabajadores */

Route::get('admin/trabajadores', [AdminController::class,'trabajadores'])->middleware('auth.admin')->name('admin.trabajadores');
Route::resource('trabajadores',TrabajadorController::class)->middleware('auth.admin');
   
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

// Route::get('/posts',[PostController::class, 'index']);

// Route::resource('publicaciones',PostController::class)->middleware('auth.profesor');





Route::post('/post/post_delete',[PostController::class, 'eliminar_post'])   
    ->middleware('auth.profesor')
    ->name('post.delete');

Route::get('/curso/{id}/nueva/{tipo}', [PostController::class,'createPostCurso'])->middleware('auth.profesor')->name('post.curso.create');

Route::get('admin/nueva/{tipo}', [PostController::class,'create'])->middleware('auth.admin')->name('admin.post.create');
Route::post('/post/eliminar_post_crear', [PostController::class,'eliminar_post_crear'])->middleware('auth.profesor')->name('post.delete.crear');
Route::post('admin/post/guardar', [PostController::class,'store'])->middleware('auth.admin')->name('admin.post.store');
Route::get('admin/{tipo}/{id}/editar', [PostController::class,'edit'])->middleware('auth.admin')->name('admin.post.edit');
Route::post('/post/eliminar_post_editar', [PostController::class,'eliminar_post_editar'])->middleware('auth.profesor')->name('post.delete.editar');
Route::post('admin/post/actualizar', [PostController::class,'update'])->middleware('auth.admin')->name('admin.post.update');
Route::delete('admin/post/{id}/eliminar', [PostController::class,'destroy'])->middleware('auth.admin')->name('admin.post.destroy');


//Comentarios

Route::resource('comentarios',ComentarioController::class);

//Archivos
Route::resource('archivos',ArchivoController::class);

Route::post('/archivo/archivo_delete',[ArchivoController::class, 'eliminar_archivo'])
    ->name('archivo.delete');

Route::post('/archivo/archivo_delete_editar',[ArchivoController::class, 'eliminar_archivo_editar'])
    ->name('archivo.delete.editar');

//Post-alumnos

Route::post('/alumnos_post',[PostController::class, 'alumnos'])
    ->name('post.alumnos');

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

// Route::get('prueba', function(){

//     $contents = (collect(Storage::disk("google")->listContents("/", false))->where('type', '=', 'file')->where('name', '=', 'pdf.pdf')->first()['path']);

//     return view('prueba')->with('contents',$contents);
// });
   