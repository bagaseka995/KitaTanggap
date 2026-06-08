<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Tentukan apakah user berwenang membuat request ini.
     * Registrasi publik boleh dilakukan siapapun.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk registrasi akun (REQ-01, REQ-02).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],

            'email' => ['required', 'email', 'unique:users,email'],

            // REQ-02: min 8 karakter, harus mengandung huruf DAN angka
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
                'confirmed',
            ],

            'no_telepon' => ['nullable', 'string', 'max:20'],

            // Peran 'admin' tidak boleh dipilih saat registrasi publik
            'peran' => ['required', 'in:relawan,donatur'],
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia (REQ-02).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // nama_lengkap
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string'   => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max'      => 'Nama lengkap maksimal 100 karakter.',

            // email
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar. Gunakan email lain atau masuk ke akun Anda.',

            // password
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.regex'     => 'Password harus mengandung kombinasi huruf dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            // no_telepon
            'no_telepon.string' => 'Nomor telepon harus berupa teks.',
            'no_telepon.max'    => 'Nomor telepon maksimal 20 karakter.',

            // peran
            'peran.required' => 'Pilihan peran wajib diisi.',
            'peran.in'       => 'Peran yang dipilih tidak valid. Pilih Relawan atau Donatur.',
        ];
    }

    /**
     * Label atribut dalam Bahasa Indonesia untuk pesan error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'nama lengkap',
            'email'        => 'email',
            'password'     => 'password',
            'no_telepon'   => 'nomor telepon',
            'peran'        => 'peran',
        ];
    }
}
