<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Relación con lotes
     */
    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Relación con ventas
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    /**
     * Get the formatted price attribute.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    /**
     * Incrementar stock del producto
     */
    public function incrementStock(int $quantity): void
    {
        $this->increment('quantity', $quantity);
    }

    /**
     * Decrementar stock del producto
     */
    public function decrementStock(int $quantity): void
    {
        $this->decrement('quantity', $quantity);
    }
}
