<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SantriRequest extends FormRequest
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
            'kelas' => 'required|exists:kelas,id',
            'kamar' => 'required|exists:kamars,id',
            'nama_lengkap' => 'required|string|min:3|max:225',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'kelurahan_id' => 'required|exists:kelurahans,id',
            'dusun' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'whatsapp' => 'required|string|max:13',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'tahun_masuk' => 'required|date',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'foto' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
