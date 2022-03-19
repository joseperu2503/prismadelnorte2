<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoPost extends Model
{
    use HasFactory;
    protected $table = 'alumno_posts';
    protected $fillable = [
        'id_post',
        'id_aula',
        'id_alumno'
    ];
}
