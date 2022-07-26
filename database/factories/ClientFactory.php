<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->safeEmail()
        ];
    }
}
