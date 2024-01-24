<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product_id = $this->route('product')->id;
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'barcode' => 'required|string|max:50|unique:products,barcode,' . $product_id,
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'purchase_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'required|integer',
            'status' => 'boolean',
        ];
    }
}
