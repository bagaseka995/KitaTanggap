<?php

namespace Database\Seeders;

use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RelawanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 3 user relawan jika belum ada
        $users = [
            [
                'nama_lengkap'      => 'Budi Santoso',
                'email'             => 'budi.relawan@kitatanggap.id',
                'password'          => Hash::make('Relawan@123'),
                'peran'             => 'relawan',
                'status_akun'       => 'aktif',
                'email_verified_at' => now(),
                'no_telepon'        => '081234000001',
            ],
            [
                'nama_lengkap'      => 'Siti Rahayu',
                'email'             => 'siti.relawan@kitatanggap.id',
                'password'          => Hash::make('Relawan@123'),
                'peran'             => 'relawan',
                'status_akun'       => 'aktif',
                'email_verified_at' => now(),
                'no_telepon'        => '081234000002',
            ],
            [
                'nama_lengkap'      => 'Ahmad Fauzi',
                'email'             => 'ahmad.relawan@kitatanggap.id',
                'password'          => Hash::make('Relawan@123'),
                'peran'             => 'relawan',
                'status_akun'       => 'aktif',
                'email_verified_at' => now(),
                'no_telepon'        => '081234000003',
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(['email' => $data['email']], $data);
        }

        $u1 = User::where('email', 'budi.relawan@kitatanggap.id')->first();
        $u2 = User::where('email', 'siti.relawan@kitatanggap.id')->first();
        $u3 = User::where('email', 'ahmad.relawan@kitatanggap.id')->first();

        // Relawan 1 — status: pending (baru daftar)
        Relawan::firstOrCreate(['user_id' => $u1->id], [
            'keahlian'          => 'medis, P3K',
            'pengalaman'        => 'Pernah terlibat dalam penanganan bencana banjir 2024 di Bekasi sebagai tenaga medis sukarela.',
            'lokasi_domisili'   => 'Jakarta Selatan',
            'ketersediaan'      => true,
            'status_verifikasi' => 'pending',
        ]);

        // Relawan 2 — status: terverifikasi (siap ditugaskan)
        Relawan::firstOrCreate(['user_id' => $u2->id], [
            'keahlian'          => 'SAR, logistik, komunikasi',
            'pengalaman'        => 'Anggota aktif BASARNAS selama 5 tahun. Berpengalaman dalam misi pencarian dan penyelamatan di pegunungan dan perairan.',
            'lokasi_domisili'   => 'Bandung',
            'ketersediaan'      => true,
            'status_verifikasi' => 'terverifikasi',
        ]);

        // Relawan 3 — status: ditolak
        Relawan::firstOrCreate(['user_id' => $u3->id], [
            'keahlian'          => 'memasak',
            'pengalaman'        => '',
            'lokasi_domisili'   => 'Surabaya',
            'ketersediaan'      => false,
            'status_verifikasi' => 'ditolak',
        ]);

        $this->command->info('✅ 3 data relawan (pending/terverifikasi/ditolak) berhasil di-seed.');
    }
}
