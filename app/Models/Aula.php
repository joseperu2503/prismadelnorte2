<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = 'aulas';
    protected $fillable = [
        'codigo',
        'aula',
        'id_nivel',
        'abreviatura'
    ];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class,'id_aula');
    }
}
