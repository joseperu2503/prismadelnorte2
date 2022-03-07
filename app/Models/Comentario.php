<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';
    protected $fillable = [
        'id_post',
        'id_user',
        'descripcion'
    ];


    public function post(){
        return $this->belongsTo(Post::class,'id_post');
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function getAutorAttribute()
    {
        if($this->user->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->user->dni)
                ->first();
            return $profesor->primer_nombre." ".$profesor->apellido_paterno;

        }
        if($this->user->role=='alumno'){
            $alumno=Alumno::select('*')
                ->where('dni',$this->user->dni)
                ->first();
            return $alumno->primer_nombre." ".$alumno->apellido_paterno;

        }
        else if($this->user->role=='admin'){
            return 'Administración';

        }
    }

    public function getAutorFotoAttribute()
    {
        if($this->user->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->user->dni)
                ->first();

            return $profesor->foto_perfil;
        }
        else if($this->user->role=='alumno'){

            $alumno=Alumno::select('*')
                ->where('dni',$this->user->dni)
                ->first();

            return $alumno->foto_perfil;
        }
        else if($this->user->role=='admin'){

            return '/storage/fotos_perfil/logo.png';
        }
        
    }

    public function getFechaCreacionAttribute()
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return $this->created_at->diffForHumans();
    }


}
