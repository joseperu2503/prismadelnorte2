<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => '1',
            'titulo' => $this->faker->sentence,
            'descripcion' => $this->faker->sentence(40),
            'id_curso' => rand(1,10),
            'tipo'=> rand(1,2),
            'carpeta'=> null    
        ];
    }
}
