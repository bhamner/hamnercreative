<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
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
            'content_name' => ['required', 'max:255'],
            'client_id' => ['required', 'numeric', 'exists:App\Models\Client,id'],
            'content_id' => ['nullable', 'numeric', 'exists:App\Models\Content,id'],
            'content_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp'],
            'content_quantity' => ['nullable', 'numeric', 'min:0'],
            'content_price' => ['nullable', 'numeric', 'min:0'],
            'content_in_stock' => ['nullable', 'boolean'],
            'quill_contents' => ['nullable', 'string'],
        ];
    }
}
