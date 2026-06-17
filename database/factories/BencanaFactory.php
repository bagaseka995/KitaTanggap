<?php

namespace Database\Factories;

use App\Models\Bencana;
use Illuminate\Database\Eloquent\Factories\Factory;

class BencanaFactory extends Factory
{
    protected $model = Bencana::class;

    public function definition(): array
    {
        return [
            'nama_bencana' => $this->faker->sentence(3),
            'jenis_bencana' => 'gempa',
            'lokasi' => $this->faker->city,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'tanggal_kejadian' => $this->faker->date(),
            'status_siaga' => $this->faker->randomElement(['waspada', 'siaga', 'awas']),
            'deskripsi' => $this->faker->paragraph,
            'target_dana' => $this->faker->numberBetween(1000000, 50000000),
            'status_aktif' => true,
        ];
    }
}
