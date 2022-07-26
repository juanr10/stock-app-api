<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    public function definition()
    {
        $product = Product::factory()->create();

        return [
            'product_id' => $product->id,
            'provider_id' => Provider::factory(),
            'quantity' => 3,
            'price' => 3 * $product->price
        ];
    }
}
