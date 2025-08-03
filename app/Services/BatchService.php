<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BatchService
{
    public function createBatch(array $data): Batch
    {
        return DB::transaction(function () use ($data) {

            $batch = Batch::create([
                'production_date' => $data['production_date'],
                'description' => $data['description'] ?? null,
            ]);

            // Procesar productos del lote
            $this->attachProductsToBatch($batch, $data['products']);

            return $batch->load('products');
        });
    }

    public function updateBatch(Batch $batch, array $data): Batch
    {
        return DB::transaction(function () use ($batch, $data) {
            if (isset($data['products'])) {
                $this->revertBatchStock($batch);
                $batch->products()->detach();
                $this->attachProductsToBatch($batch, $data['products']);
            }

            // Actualizar datos del lote
            $batch->update(collect($data)->only(['production_date', 'description'])->toArray());

            return $batch->load('products');
        });
    }

    public function deleteBatch(Batch $batch): void
    {
        DB::transaction(function () use ($batch) {
            $this->revertBatchStock($batch);
            $batch->delete();
        });
    }

    private function attachProductsToBatch(Batch $batch, array $products): void
    {
        foreach ($products as $productData) {
            $product = Product::findOrFail($productData['product_id']);

            $batch->products()->attach($product->id, [
                'quantity' => $productData['quantity']
            ]);

            $product->incrementStock($productData['quantity']);
        }
    }

    private function revertBatchStock(Batch $batch): void
    {
        foreach ($batch->products as $product) {
            $quantity = $product->pivot->quantity;
            $product->decrementStock($quantity);
        }
    }
}
