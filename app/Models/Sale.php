<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'sale_date',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relación con cliente
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relación con productos
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    /**
     * Get the formatted total amount attribute.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return number_format($this->total_amount, 2);
    }

    /**
     * Obtener productos con sus detalles de venta
     */
    public function getProductsWithDetailsAttribute()
    {
        return $this->products()->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price,
                'subtotal' => $product->pivot->subtotal,
            ];
        });
    }

    /**
     * Calcular el total de la venta basado en los productos
     */
    public function calculateTotal(): void
    {
        $total = $this->products()->sum('sale_product.subtotal');
        $this->update(['total_amount' => $total]);
    }
}
