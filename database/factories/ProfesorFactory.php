<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesorFactory extends Factory
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
            'password' => $this->faker->word(4),
            'foto_perfil' => 'man.png'

        ];
    }
}
