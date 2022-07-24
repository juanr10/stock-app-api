<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_products()
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

        $this->json('GET', 'api/products', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        "name" => $product1->name,
                        "description" => $product1->description,
                        "price" => $product1->price,
                        "created_at" => $product1->created_at,
                        "updated_at" => $product1->updated_at
                    ],
                    [
                        "name" => $product2->name,
                        "description" => $product2->description,
                        "price" => $product2->price,
                        'created_at' => $product2->created_at,
                        'updated_at' => $product2->updated_at
                    ],
                ]
            ]);
    }
}
