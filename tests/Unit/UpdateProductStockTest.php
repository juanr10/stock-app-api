<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use App\Application\ProductsStock\UpdateStock;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductStockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_update_product_stock_increase_method()
    {
        $product = Product::factory()->create();
        $initialProductStock = $product->stock->quantity;
        $quantityToIncrease = 3;

        $productStock = new UpdateStock($product->stock);
        $productStock->increase($quantityToIncrease);

        //Refresh product data
        $product->refresh();

        $this->assertEquals($product->stock->quantity , $initialProductStock + $quantityToIncrease);
    }

    /** @test */
    public function test_update_product_stock_decrease_method()
    {
        $product = Product::factory()->create();
        $initialProductStock = $product->stock->quantity;
        $quantityToDecrease = 3;

        $productStock = new UpdateStock($product->stock);
        $productStock->decrease( $quantityToDecrease);

        //Refresh product data
        $product->refresh();

        $this->assertEquals($product->stock->quantity , $initialProductStock - $quantityToDecrease);
    }
}
