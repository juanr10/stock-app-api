<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Models\Purchase;
use App\Http\Requests\PurchaseStoreRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Application\ProductsStock\UpdateStock;
class PurchaseController extends Controller
{
    public function store(PurchaseStoreRequest $request)
    {
        $statusCode = 500;
        $response = null;

        DB::beginTransaction();

        try {
            $purchase = Purchase::create($request->all());
            $productStock = new UpdateStock($purchase->product->stock);
            $productStock->increase($purchase->quantity);

            DB::commit();

            $statusCode = 201;

            $response = [
                'data' => $purchase
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
