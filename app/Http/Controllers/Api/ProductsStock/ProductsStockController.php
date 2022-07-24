<?php

namespace App\Http\Controllers\Api\ProductsStock;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductsStockController extends Controller
{
    public function getProductStock($product_id)
    {
        $product = Product::findOrFail($product_id);

        return response()->json([
            'data' => $product->stock->quantity
        ]);
    }

    public function getAllProductsWithStock()
    {
        return response()->json([
            'data' =>  Product::with('stock')->get()
        ]);
    }
}
