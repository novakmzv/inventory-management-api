<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * Relación con ventas
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Obtener el total de ventas del cliente
     */
    public function getTotalSalesAttribute(): string
    {
        return number_format($this->sales()->sum('total_amount'), 2);
    }

    /**
     * Obtener el número total de compras del cliente
     */
    public function getTotalPurchasesAttribute(): int
    {
        return $this->sales()->count();
    }
}
