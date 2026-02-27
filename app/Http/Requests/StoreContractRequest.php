<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'tenant_id' => 'required|exists:users,id',
            'rent_amount' => 'required|numeric|min:0|max:999999.99',
            'unit_name' => 'required|string|min:3|max:255',
            'customer_name' => 'required|string|min:2|max:255',
            'start_date' => 'required|date_format:Y-m-d|before_or_equal:today',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
        ];
    }
}
