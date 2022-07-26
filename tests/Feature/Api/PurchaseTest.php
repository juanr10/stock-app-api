<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Purchase;
use App\Models\Provider;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_store_a_purchase()
    {
        $product = Product::factory()->create();
        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => 3,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        // Assert that we get back a status 201:
        $response->assertCreated();

        // Assert that at least one column gets returned from the response in the format we need
        $response->assertJson([
            'data' => ['price' => $newPurchase->price]
        ]);

        // Assert the table purchases contains data
        $this->assertDatabaseHas(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_product_not_exists()
    {
        $notExistentProduct = (object) [
            'id' => 999,
            'name' => 'Anillo Desire',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, earum!',
            'price' => null
        ];

        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $notExistentProduct->id,
            'provider_id' => $provider->id,
            'quantity' => 3,
            'price' => 3 * $notExistentProduct->price
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        // Assert that we get back a status 422 Unprocessable Entity:
        $response->assertStatus(422);

        // Assert the table purchases not contains data
        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_provider_not_exists()
    {
        $product = Product::factory()->create();

        $notExistentProvider = (object) [
            'id' => 999,
            'name' => 'ProviderTest',
            'cif' => '12345678',
            'email' => 'test@test.com'
        ];

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $notExistentProvider->id,
            'quantity' => 3,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_quantity_is_null()
    {
        $product = Product::factory()->create();
        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => null,
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_quantity_is_not_numeric()
    {
        $product = Product::factory()->create();
        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => 'testing',
            'price' => 3 * $product->price
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_price_is_null()
    {
        $product = Product::factory()->create();
        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => 3,
            'price' => null
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function cannot_store_a_purchase_if_the_price_is_not_numeric()
    {
        $product = Product::factory()->create();
        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => 3,
            'price' => null
        ]);

        $response = $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing(
            'purchases',
            $newPurchase->toArray()
        );
    }

    /** @test */
    public function check_if_product_stock_increase_when_a_purchase_is_created()
    {
        $product = Product::factory()->create();
        $initialProductStock = $product->stock->quantity;

        $provider = Provider::factory()->create();

        $newPurchase = Purchase::factory()->make([
            'product_id' => $product->id,
            'provider_id' => $provider->id,
            'quantity' => 3,
            'price' => 3 * $product->price
        ]);

        $this->postJson(
            route('api.purchases.store'),
            $newPurchase->toArray()
        );

        //Refresh product data
        $product->refresh();

        $this->assertEquals($product->stock->quantity, $initialProductStock + $newPurchase->quantity);
    }
}
