<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BatchCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => BatchResource::collection($this->collection),
            'code' => 200,
            'message' => 'Batches retrieved successfully'
        ];
    }
}
