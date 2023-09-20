<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    public function definition()
    {
        return [
            "name" => fake()->word(),
            "display" => fake()->boolean(),
            "color" => fake()->hexColor()
        ];
    }
}
