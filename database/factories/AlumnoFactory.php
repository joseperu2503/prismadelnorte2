<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dni' => $this->faker->numberBetween(10000000, 99999999),
            'primer_nombre' => $this->faker->firstName,
            'segundo_nombre' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'telefono' => $this->faker->numberBetween(900000000, 999999999),
            'email' => $this->faker->email,
            'direccion' => $this->faker->address,
            'id_genero' => rand(1,2),
            'password' => 'hola',
            'foto_perfil' => '/storage/fotos_perfil/estudiante.png',
            'id_aula'=> rand(1,10),
            'id_grado'=> rand(1,10),
            'fecha_nacimiento'=> $this->faker->date(),
        ];
    }
}
