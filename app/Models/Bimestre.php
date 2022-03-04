<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimestre extends Model
{
    use HasFactory;
    protected $table = 'bimestres';
    protected $fillable = [
        'num_bimestre',
        'bimestre'
    ];
}
