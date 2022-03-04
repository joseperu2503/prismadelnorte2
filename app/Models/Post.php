<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'id_curso'
    ];

    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function curso(){
        return $this->belongsTo(Curso::class,'id_curso');
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

    public function getAutorImagenAttribute()
    {
        if($this->user->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->user->dni)
                ->first();

                return $profesor->foto_perfil;
        }
        else if($this->user->role=='admin'){

            return 'logo.png';
        }
    }

    public function getFechaCreacionAttribute()
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return $this->created_at->format('d')." de ".$meses[(int)$this->created_at->format('m')-1]." a las ".$this->created_at->format('H:i');
    }

}
