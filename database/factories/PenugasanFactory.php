<?php

namespace Database\Factories;

use App\Models\Penugasan;
use App\Models\Relawan;
use App\Models\Bencana;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenugasanFactory extends Factory
{
    protected $model = Penugasan::class;

    public function definition(): array
    {
        return [
            'relawan_id' => Relawan::factory(),
            'bencana_id' => Bencana::factory(),
            'tanggal_tugas' => $this->faker->date(),
            'status_tugas' => 'ditugaskan',
        ];
    }
}
