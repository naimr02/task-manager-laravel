<?php
// database/factories/CategoryFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'color' => $this->faker->hexColor(),
            'user_id' => User::factory(),
        ];
    }
}
