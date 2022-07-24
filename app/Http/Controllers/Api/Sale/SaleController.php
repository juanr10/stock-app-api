<?php

namespace App\Http\Controllers\Api\Sale;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function store(SaleRequest $request)
    {
        return response()->json([
            'data' => Sale::create($request->all())
        ], 201);
    }
}
