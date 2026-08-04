<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeleteUserRequest extends FormRequest
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
        $confirmationCode = substr((string) Auth::user()->vendor_id, 0, 5);

        return [
            'deleteConfirmationCode' => [
                'required',
                'numeric',
                Rule::in([$confirmationCode]),
            ],
        ];
    }
}
