<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelawanProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->peran === 'relawan';
    }

    public function rules(): array
    {
        return [
            'keahlian'        => ['required', 'string', 'max:255'],
            'pengalaman'      => ['nullable', 'string'],
            'lokasi_domisili' => ['required', 'string', 'max:150'],
            'ketersediaan'    => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'keahlian.required'        => 'Keahlian wajib diisi (pisahkan dengan koma).',
            'keahlian.max'             => 'Keahlian maksimal 255 karakter.',
            'lokasi_domisili.required' => 'Lokasi domisili wajib diisi.',
            'lokasi_domisili.max'      => 'Lokasi domisili maksimal 150 karakter.',
            'ketersediaan.required'    => 'Status ketersediaan wajib dipilih.',
            'ketersediaan.boolean'     => 'Status ketersediaan tidak valid.',
        ];
    }
}
