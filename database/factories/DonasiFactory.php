<?php

namespace Database\Factories;

use App\Models\Donasi;
use App\Models\User;
use App\Models\Bencana;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonasiFactory extends Factory
{
    protected $model = Donasi::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bencana_id' => Bencana::factory(),
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(10)),
            'nama_donatur' => $this->faker->name,
            'email_donatur' => $this->faker->email,
            'nominal' => $this->faker->numberBetween(10000, 1000000),
            'metode_pembayaran' => 'transfer_bank',
            'status_bayar' => 'pending',
        ];
    }
}
