<?php

namespace Tests\Integration;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Bencana;
use App\Models\Relawan;

abstract class IntegrationTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup default configuration for tests if needed
    }

    protected function createAdmin()
    {
        return User::factory()->create([
            'peran' => 'admin',
            'email_verified_at' => now(),
            'status_akun' => 'aktif',
        ]);
    }

    protected function createRelawan()
    {
        return User::factory()->create([
            'peran' => 'relawan',
            'email_verified_at' => now(),
            'status_akun' => 'aktif',
        ]);
    }

    protected function createDonatur()
    {
        return User::factory()->create([
            'peran' => 'donatur',
            'email_verified_at' => now(),
            'status_akun' => 'aktif',
        ]);
    }

    protected function createBencanaAktif()
    {
        return Bencana::factory()->create([
            'status_aktif' => true,
        ]);
    }

    protected function createRelawanTerverifikasi()
    {
        $user = $this->createRelawan();
        Relawan::factory()->create([
            'user_id' => $user->id,
            'status_verifikasi' => 'terverifikasi',
        ]);
        return $user;
    }
}
