<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Models\Batch;
use App\Services\BatchService;
use Illuminate\Http\JsonResponse;

class BatchController extends Controller
{

    public function __construct(
        private BatchService $batchService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $batches = Batch::with('products')->orderBy('production_date', 'desc')->get();

        return response()->json([
            'data' => $batches,
            'code' => 200,
            'message' => 'Batches retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBatchRequest $request): JsonResponse
    {
        $batch = $this->batchService->createBatch($request->validated());

        return response()->json([
            'data' => $batch,
            'code' => 201,
            'message' => 'Batch created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch): JsonResponse
    {
        $batch->load('products');

        return response()->json([
            'data' => $batch,
            'code' => 200,
            'message' => 'Batch retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchRequest $request, Batch $batch): JsonResponse
    {
        $updatedBatch = $this->batchService->updateBatch($batch, $request->validated());

        return response()->json([
            'data' => $updatedBatch,
            'code' => 200,
            'message' => 'Batch updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch): JsonResponse
    {
        $this->batchService->deleteBatch($batch);

        return response()->json([
            'data' => null,
            'code' => 200,
            'message' => 'Batch deleted successfully'
        ]);
    }
}
