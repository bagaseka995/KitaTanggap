<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed 1 akun admin untuk sistem KitaTanggap.
     *
     * Kredensial:
     *   Email    : admin@kitatanggap.id
     *   Password : Admin@1234
     *
     * PENTING: Ganti password ini segera sebelum deploy ke produksi!
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kitatanggap.id'],
            [
                'nama_lengkap'      => 'Administrator KitaTanggap',
                'password'          => Hash::make('Admin@1234'),   // bcrypt cost default (12)
                'no_telepon'        => '081234567890',
                'peran'             => 'admin',
                'status_akun'       => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Akun admin berhasil dibuat: admin@kitatanggap.id');
    }
}
