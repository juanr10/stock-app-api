<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'cif' => fake()->numerify('########'),
            'email' => fake()->safeEmail()
        ];
    }
}
