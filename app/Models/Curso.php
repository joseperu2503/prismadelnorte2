<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'cursos';
    protected $fillable = [
        'codigo',
        'nombre',
        'id_aula',
        'id_profesor'
    ];

    public function profesor(){
        return $this->belongsTo(Profesor::class,'id_profesor');
    }

    public function aula(){
        return $this->belongsTo(Aula::class,'id_aula');
    }

    public function nota_alumno($id_curso, $id_bimestre, $id_evaluacion, $num_evaluacion)
    {

        $nota=DB::table('notas')->where('id_curso', $id_curso)
        ->where('id_bimestre', $id_bimestre)
        ->where('id_evaluacion', $id_evaluacion)
        ->where('num_evaluacion', $num_evaluacion)
        ->first();
        return $nota;  
        
    }
}
