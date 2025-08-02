<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
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
            'production_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'production_date.required' => 'La fecha de producción es requerida.',
            'products.required' => 'Debe agregar al menos un producto al lote.',
            'products.*.product_id.exists' => 'El producto seleccionado no existe.',
            'products.*.quantity.min' => 'La cantidad debe ser mayor a 0.',
        ];
    }
}
