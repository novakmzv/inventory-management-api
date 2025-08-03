<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'production_date' => $this->production_date,
            'description' => $this->description,
            'products' => $this->products_with_quantities,
            'total_products' => $this->total_products,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
