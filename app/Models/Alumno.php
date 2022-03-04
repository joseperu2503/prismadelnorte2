<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $fillable = [
        'dni',
        'primer_nombre',
        'segundo_nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'departamento',
        'provincia',
        'distrito',
        'religion',
        'discapacidad',
        'telefono',      
        'email',
        'direccion',
        'foto_perfil',
        'id_genero',
        'password',
        'id_grado',
        'id_aula',
        'nombre_padre',
        'dni_padre',
        'telefono_padre',
        'nombre_madre',
        'dni_madre',
        'telefono_madre',
        'nombre_apoderado',
        'dni_apoderado',
        'telefono_apoderado'
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }
}
