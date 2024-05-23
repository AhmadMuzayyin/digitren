<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'pengirim_id' => ['required', 'exists:santris,id'],
            'penerima_id' => ['required', 'exists:santris,id'],
            'nominal' => ['required', 'numeric'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
