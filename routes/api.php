<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sale\SaleController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\ProductsStock\ProductsStockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get(
    'products',
    [ProductController::class, 'getProducts']
)->name('api.products.index');

Route::get(
    'products/{product_id}/stock',
    [ProductsStockController::class, 'getProductStock']
)->name('api.product.stock');

Route::get(
    'products/stock',
    [ProductsStockController::class, 'getAllProductsWithStock']
)->name('api.products.stock');

Route::post(
    'sales',
    [SaleController::class, 'store']
)->name('api.sales.store');
