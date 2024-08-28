<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'logo' => ['required', 'mimes:png,jpg', 'max:5020'],
            'favicon' => ['required', 'mimes:png,jpg', 'max:5020'],
            'whatsapp_api_key' => ['required', 'string', 'min:32', 'max:32'],
            'whatsapp_feature' => ['required'],
            'log_activity' => ['required'],
        ];
    }
}
