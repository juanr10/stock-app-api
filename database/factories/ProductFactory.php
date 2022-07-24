<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductsStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement(['Anillo Desire', 'Anillo The Zipper', 'Collar Candado', 'Pendientes Nova', 'Pulsera Icy', 'Charm Dino', 'Pulsera Memora', 'Collar Drop']),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 30, 150),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            ProductsStock::create([
                'product_id' => $product->id,
                'quantity' => fake()->randomNumber(2)
            ]);
        });
    }
}
