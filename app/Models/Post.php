<?php

namespace App\Models;

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
        'iframe',
        'descripcion',
        'id_curso',
        'tarea',
        'carpeta'
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
        return $this->created_at->diffForHumans();
    }

    public function getArchivosAttribute()
    {
        $archivos = collect(Storage::disk("google")->listContents($this->carpeta, false))->where('type', '=', 'file');
        return $archivos;
    }

}
