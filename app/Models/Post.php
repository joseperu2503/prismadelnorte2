<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'id_user',
        'titulo',
        'imagen',
        'descripcion',
        'id_curso',
        'tipo',
        'carpeta',
        'estado',
        'recibir',
        'fecha_publicacion'
    ];

    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function curso(){
        return $this->belongsTo(Curso::class,'id_curso');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class,'id_post')->orderby('created_at','asc');
    }

    public function getAutorAttribute()
    {
        if($this->user->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->user->dni)
                ->first();
            return $profesor->primer_nombre." ".$profesor->apellido_paterno;

        }
        else if($this->user->role=='admin'){
            return 'Administración';

        }
    }

    public function getFotoAutorAttribute()
    {
        if($this->user->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->user->dni)
                ->first();

                return $profesor->foto_perfil;
        }
        else if($this->user->role=='admin'){

            return '/storage/fotos_perfil/logo.png';
        }
    }

    public function getFechaCreacionAttribute()
    {   
        return Carbon::parse($this->fecha_publicacion)->diffForHumans();
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class,'id_post');
    }

    public function alumnospost()
    {
        return $this->hasMany(AlumnoPost::class,'id_post');
    }

}
