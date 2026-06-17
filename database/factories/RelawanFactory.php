<?php

namespace Database\Factories;

use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelawanFactory extends Factory
{
    protected $model = Relawan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'keahlian' => $this->faker->words(3, true),
            'pengalaman' => $this->faker->sentence,
            'lokasi_domisili' => $this->faker->city,
            'ketersediaan' => true,
            'status_verifikasi' => 'pending',
        ];
    }
}
