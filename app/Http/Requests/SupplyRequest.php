<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyRequest extends FormRequest
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
        return [
            'supply_name' => 'required|string|max:255',
            'supply_price' => 'nullable|numeric|min:0',
            'supply_description' => 'required|string',
            'supply_quantity' =>'nullable|integer'
        ];
    }
}
