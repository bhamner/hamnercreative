<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'order_title' => ['required', 'max:255'],
            'order_id' => ['nullable', 'numeric', 'exists:App\Models\Order,id'],
            'order_client' => ['required', 'numeric', 'exists:App\Models\Client,id'],
            'order_status' => ['required', 'in:paid,open'],
            'order_date' => ['required', 'date'],
            'service_name.*' => ['max:255'],
            'service_rate.*' => ['nullable', 'numeric'],
            'service_quantity.*' => ['nullable', 'numeric'],
        ];
    }
}
