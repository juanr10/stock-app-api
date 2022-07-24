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

    /** @test */
    public function can_get_all_products_with_the_stock()
    {
        $product1 = Product::factory()->create([
            "name" => "Anillo Desire",
            "description" => "Quo dicta hic eum ad unde ad et velit.",
            "price" => 20.54,
        ]);

        $product2 = Product::factory()->create([
            "name" => "Pulsera Icy",
            "description" => "Quo dicta hic eum ad unde ad et velit.",
            "price" => 54.18
        ]);

        $this->json('GET', 'api/products/stock', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        "name" => $product1->name,
                        "description" => $product1->description,
                        "price" => $product1->price,
                        "created_at" => $product1->created_at,
                        "updated_at" => $product1->updated_at,
                        "stock" => [
                            'product_id' => $product1->stock->product_id,
                            'quantity' =>  $product1->stock->quantity,
                            'updated_at' => $product1->stock->updated_at,
                        ]
                    ],
                    [
                        "name" => $product2->name,
                        "description" => $product2->description,
                        "price" => $product2->price,
                        "created_at" => $product2->created_at,
                        "updated_at" => $product2->updated_at,
                        "stock" => [
                            'product_id' => $product2->stock->product_id,
                            'quantity' =>  $product2->stock->quantity,
                            'updated_at' => $product2->stock->updated_at,
                        ]
                    ],
                ]
            ]);
    }
}
