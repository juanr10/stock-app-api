<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsStockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_the_stock_from_a_product()
    {
        $product = Product::factory()->create([
            "name" => "Anillo Desire",
            "description" => "Quo dicta hic eum ad unde ad et velit.",
            "price" => 20.54,
        ]);

        $this->json('GET', 'api/products/' . $product->id . '/stock', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'data' =>  $product->stock->quantity
            ]);
    }

    /** @test */
    public function can_not_get_the_stock_from_a_non_existent_product()
    {
        $this->json('GET', 'api/products/1/stock', ['Accept' => 'application/json'])
            ->assertStatus(404);
    }
}
