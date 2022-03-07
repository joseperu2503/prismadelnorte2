<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function getNombreAttribute()
    {
        if($this->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->dni)
                ->first();
            return $profesor->primer_nombre." ".$profesor->apellido_paterno;

        }
        else if($this->role=='admin'){
            return 'Administración';

        }
    }

    public function getFotoAttribute()
    {
        if($this->role=='profesor'){
            $profesor=Profesor::select('*')
                ->where('dni',$this->dni)
                ->first();

                return $profesor->foto_perfil;
        }
        else if($this->role=='alumno'){

            $alumno=Alumno::select('*')
                ->where('dni',$this->dni)
                ->first();

            return $alumno->foto_perfil;
        }
        else if($this->role=='admin'){

            return '/storage/fotos_perfil/logo.png';
        }
    }
}
