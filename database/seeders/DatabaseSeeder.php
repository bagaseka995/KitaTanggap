<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database KitaTanggap.
     *
     * Urutan penting:
     *   1. UserSeeder   → admin harus ada dulu (BencanaSeeder butuh admin_id)
     *   2. BencanaSeeder → data contoh bencana yang mereferensikan admin
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BencanaSeeder::class,
            RelawanSeeder::class,
        ]);
    }
}

