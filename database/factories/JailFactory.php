<?php

namespace Database\Factories;

use App\Enums\JailTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;


class JailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName,
            'code' => $this->faker->iban(),
            'type' => $this->faker->randomElement(array_column(JailTypeEnum::cases(), 'value')),
            'capacity' => $this->faker->numberBetween(2, 5),
            'description' => $this->faker->text(255),
        ];
    }
}
