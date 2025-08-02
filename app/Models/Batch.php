<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_date',
        'description',
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    /**
     * Relación con productos
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Obtener el total de productos en el lote
     */
    public function getTotalProductsAttribute(): int
    {
        return $this->products()->sum('batch_product.quantity');
    }

    /**
     * Obtener productos con sus cantidades
     */
    public function getProductsWithQuantitiesAttribute()
    {
        return $this->products()->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
            ];
        });
    }
}
