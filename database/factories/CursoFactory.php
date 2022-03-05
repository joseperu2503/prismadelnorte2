<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => $this->faker->word,
            'nombre' => $this->faker->word,
            'id_profesor' => rand(1,10),
            'id_aula' => rand(1,10)      

        ];
    }
}
