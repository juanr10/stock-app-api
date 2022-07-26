<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SaleFactory extends Factory
{
    public function definition()
    {
        $product = Product::factory()->create();

        return [
            'product_id' => $product->id,
            'client_id' => Client::factory(),
            'quantity' => 3,
            'price' => 3 * $product->price
        ];
    }
}
