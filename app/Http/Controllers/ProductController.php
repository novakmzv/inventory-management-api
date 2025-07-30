<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'data' => $products,
            'code' => 200,
            'message' => 'Products retrieved successfully'
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'data' => $product,
            'code' => 201,
            'message' => 'Product created successfully'
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'data' => $product,
            'code' => 200,
            'message' => 'Product retrieved successfully'
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'data' => $product->fresh(),
            'code' => 200,
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'data' => null,
            'code' => 200,
            'message' => 'Product deleted successfully'
        ]);
    }
}
