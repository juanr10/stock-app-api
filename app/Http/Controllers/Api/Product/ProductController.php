<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getProducts()
    {
        return response()->json([
            'data' => Product::all()
        ]);
    }
}
