<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $table = 'profesors';
    protected $fillable = [
        'dni',
        'primer_nombre',
        'segundo_nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'email',
        'direccion',
        'id_genero',   
        'password',
        'foto_perfil'   
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class,'id_profesor');
    }
    
    public function setCursosidAttribute()
    {
        $cursos = Curso::select('id')           
            ->where('id_profesor', $this->id)
            ->get();

        return $cursos;
    }


}
