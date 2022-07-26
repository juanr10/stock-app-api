<?php

namespace App\Http\Controllers\Api\Sale;

use App\Models\Sale;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Application\ProductsStock\UpdateStock;
class SaleController extends Controller
{
    public function store(SaleRequest $request)
    {
        $statusCode = 500;
        $response = null;

        DB::beginTransaction();

        try {
            $sale = Sale::create($request->all());
            $productStock = new UpdateStock($sale->product->stock);
            $productStock->decrease($sale->quantity);

            DB::commit();

            $statusCode = 201;

            $response = [
                'data' => $sale
            ];
        } catch (\Exception $e) {
            DB::rollback();

            $response = [
                'error' => $e
            ];
        }

        return response()->json($response, $statusCode);
    }
}
