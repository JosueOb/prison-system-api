<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(45),
            'description' => $this->faker->text(255),
        ];
    }
}
