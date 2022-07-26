<?php

namespace App\Application\ProductsStock;

use App\Models\ProductsStock;

class UpdateStock
{
    public function __construct(ProductsStock $productStock)
    {
        $this->productStock = $productStock;
    }

    public function decrease($quantity): bool
    {
        return $this->productStock->decrement('quantity', $quantity);
    }

    public function increase($quantity): bool
    {
        return $this->productStock->increment('quantity', $quantity);
    }
}
