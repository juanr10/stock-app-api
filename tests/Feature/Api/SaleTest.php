<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_store_a_sale()
    {
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $client->id,
            'quantity' => 3,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        // Assert that we get back a status 201:
        $response->assertCreated();

        // Assert that at least one column gets returned from the response in the format we need
        $response->assertJson([
            'data' => ['price' => $newSale->price]
        ]);

        // Assert the table sales contains data
        $this->assertDatabaseHas(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_product_not_exists()
    {
        $notExistentProduct = (object) [
            'id' => 999,
            'name' => 'Anillo Desire',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, earum!',
            'price' => null
        ];

        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $notExistentProduct->id,
            'client_id' => $client->id,
            'quantity' => 3,
            'price' => 3 * $notExistentProduct->price
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        // Assert that we get back a status 422 Unprocessable Entity:
        $response->assertStatus(422);

        // Assert the table sales not contains data
        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_client_not_exists()
    {
        $product = Product::factory()->create();

        $notExistentClient = (object) [
            'id' => 999,
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'test@test.com'
        ];

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $notExistentClient->id,
            'quantity' => 3,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_quantity_is_null()
    {
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $client->id,
            'quantity' => null,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_quantity_is_not_numeric()
    {
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $client->id,
            'quantity' => 'testing',
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_price_is_null()
    {
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $client->id,
            'quantity' => 3,
            'price' => null
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }

    /** @test */
    public function can_not_store_a_sale_if_the_price_is_not_numeric()
    {
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $newSale = Sale::factory()->make([
            'product_id' => $product->id,
            'client_id' => $client->id,
            'quantity' => 3,
            'price' => 'testing'
        ]);

        $response = $this->postJson(
            route('api.sales.store'),
            $newSale->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'sales',
            $newSale->toArray()
        );
    }
}
