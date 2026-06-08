<?php

namespace Database\Seeders;

use App\Models\Bencana;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BencanaSeeder extends Seeder
{
    /**
     * Seed 5 data bencana dengan koordinat Indonesia yang akurat.
     *
     * Warna marker (REQ-09):
     *   waspada → #EAB308 (kuning)
     *   siaga   → #F97316 (oranye)
     *   awas    → #EF4444 (merah)
     */
    public function run(): void
    {
        $admin   = User::where('email', 'admin@kitatanggap.id')->first();
        $adminId = $admin?->id;

        $data = [
            [
                'nama_bencana'     => 'Banjir Jakarta 2026',
                'jenis_bencana'    => 'banjir',
                'lokasi'           => 'DKI Jakarta',
                'latitude'         => -6.2088,
                'longitude'        => 106.8456,
                'tanggal_kejadian' => '2026-05-10',
                'status_siaga'     => 'awas',
                'deskripsi'        => 'Banjir besar melanda sejumlah wilayah di DKI Jakarta akibat curah hujan ekstrem yang melampaui kapasitas drainase kota. Lebih dari 50 ribu warga terdampak dan ribuan rumah terendam.',
                'status_aktif'     => true,
                'target_dana'      => 500000000, // 500 juta
                'admin_id'         => $adminId,
            ],
            [
                'nama_bencana'     => 'Gempa Bumi Cianjur 2026',
                'jenis_bencana'    => 'gempa',
                'lokasi'           => 'Kabupaten Cianjur, Jawa Barat',
                'latitude'         => -6.8200,
                'longitude'        => 107.1400,
                'tanggal_kejadian' => '2026-05-22',
                'status_siaga'     => 'siaga',
                'deskripsi'        => 'Gempa berkekuatan M 5.8 SR mengguncang Kabupaten Cianjur. Sejumlah bangunan rusak dan warga mengungsi. Tim BNPB dan relawan lokal bergerak cepat melakukan evakuasi.',
                'status_aktif'     => true,
                'target_dana'      => 300000000, // 300 juta
                'admin_id'         => $adminId,
            ],
            [
                'nama_bencana'     => 'Erupsi Gunung Merapi 2026',
                'jenis_bencana'    => 'erupsi',
                'lokasi'           => 'Kabupaten Sleman, DI Yogyakarta',
                'latitude'         => -7.5407,
                'longitude'        => 110.4457,
                'tanggal_kejadian' => '2026-06-01',
                'status_siaga'     => 'waspada',
                'deskripsi'        => 'Aktivitas Gunung Merapi meningkat dengan awan panas guguran sejauh 1.5 km ke barat daya. PVMBG menaikkan status ke Level II (Waspada). Warga diimbau tidak beraktivitas dalam radius 3 km dari puncak.',
                'status_aktif'     => true,
                'target_dana'      => 200000000, // 200 juta
                'admin_id'         => $adminId,
            ],
            [
                'nama_bencana'     => 'Tsunami Palu 2026',
                'jenis_bencana'    => 'tsunami',
                'lokasi'           => 'Kota Palu, Sulawesi Tengah',
                'latitude'         => -0.8917,
                'longitude'        => 119.8707,
                'tanggal_kejadian' => '2026-04-15',
                'status_siaga'     => 'awas',
                'deskripsi'        => 'Gempa M 6.1 SR memicu tsunami kecil di Teluk Palu. Masyarakat pesisir diminta waspada dan menjauhi pantai. Badan Geologi memantau perkembangan intensif.',
                'status_aktif'     => false,   // sudah selesai / nonaktif
                'target_dana'      => 400000000, // 400 juta
                'admin_id'         => $adminId,
            ],
            [
                'nama_bencana'     => 'Tanah Longsor Bandung 2026',
                'jenis_bencana'    => 'tanah_longsor',
                'lokasi'           => 'Kabupaten Bandung, Jawa Barat',
                'latitude'         => -6.9175,
                'longitude'        => 107.6191,
                'tanggal_kejadian' => '2026-06-05',
                'status_siaga'     => 'waspada',
                'deskripsi'        => 'Hujan deras memicu longsor di kawasan perbukitan Bandung Selatan. Beberapa akses jalan tertutup material longsor. Warga di zona rawan diminta berhati-hati dan siap evakuasi.',
                'status_aktif'     => true,
                'target_dana'      => 150000000, // 150 juta
                'admin_id'         => $adminId,
            ],
        ];

        // Hapus data lama, masukkan yang baru agar seeder bisa diulang
        Schema::disableForeignKeyConstraints();
        Bencana::truncate();
        Schema::enableForeignKeyConstraints();
        Bencana::insert($data);

        $this->command->info('✅ 5 data bencana (koordinat akurat) berhasil di-seed.');
    }
}
