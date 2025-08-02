<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'production_date' => 'date',
            'description' => 'nullable|string|max:500',
            'products' => 'array',
            'products.*.product_id' => 'exists:products,id',
            'products.*.quantity' => 'integer|min:1',
        ];
    }
}
