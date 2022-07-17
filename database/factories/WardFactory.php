<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class WardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName,
            'location' => $this->faker->streetName,
            'description' => $this->faker->text(45),
        ];
    }
}
