<?php

namespace Tests\Integration\Auth;

use Tests\Integration\IntegrationTestCase; // Pastikan ini mengacu pada base case Anda
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class RegistrasiLoginTest extends IntegrationTestCase
{
    public function test_alur_registrasi_relawan_lengkap()
    {
        Notification::fake();

        $data = [
            'nama_lengkap' => 'Relawan Baru',
            'email' => 'relawan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'no_telepon' => '08123456789',
            'peran' => 'relawan',
        ];

        // 1. POST /register
        $response = $this->post('/register', $data);
        $response->assertRedirect(route('login'));

        // 2. Assert DB status_akun='pending'
        $this->assertDatabaseHas('users', [
            'email' => 'relawan@example.com',
            'status_akun' => 'pending',
            'peran' => 'relawan',
        ]);
        $user = User::where('email', 'relawan@example.com')->first();
        $this->assertNull($user->email_verified_at);

        // 3. Assert email verifikasi terkirim (Notification)
        Notification::assertSentTo($user, VerifyEmail::class);

        // 4. Klik link verifikasi
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verifyUrl);
        $response->assertRedirect(route('login'));

        // Assert DB
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $this->assertEquals('aktif', $user->status_akun);

        // Logout user that was authenticated via actingAs
        \Auth::logout();

        // 5. POST /login
        $response = $this->post('/login', [
            'email' => 'relawan@example.com',
            'password' => 'Password123!'
        ]);
        
        $response->assertRedirect(route('relawan.dashboard'));
        
        // Assert session aktif, token Sanctum terbuat
        $this->assertAuthenticatedAs($user);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_alur_registrasi_donatur_lengkap()
    {
        Notification::fake();

        $data = [
            'nama_lengkap' => 'Donatur Baru',
            'email' => 'donatur@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'no_telepon' => '08123456788',
            'peran' => 'donatur',
        ];

        $this->post('/register', $data);
        $user = User::where('email', 'donatur@example.com')->first();
        
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verifyUrl);
        
        $user->refresh();
        $this->assertEquals('aktif', $user->status_akun);

        \Auth::logout();

        $response = $this->post('/login', [
            'email' => 'donatur@example.com',
            'password' => 'Password123!'
        ]);

        $response->assertRedirect(route('donatur.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_5x_lockout_tunggu_bisa_login_lagi()
    {
        $user = $this->createRelawan();

        // POST /login 5x gagal
        for ($i = 0; $i < 4; $i++) {
            $this->post('/login', ['email' => $user->email, 'password' => 'Salah123!']);
        }

        // Ke-5 gagal
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'Salah123!']);
        
        // Assert: response return code / redirect dengan lockout message
        // AuthController melempar back()->withErrors jika bukan JSON, jadi 302 redirect
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->has('locked'));

        // Cek Cache key
        $requestIp = request()->ip();
        $this->assertTrue(Cache::has('login_locked_' . $requestIp));

        // Percobaan ke-6 ditolak karena dilock
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(302);
        $this->assertTrue(session()->has('locked'));

        // Manipulasi waktu
        Carbon::setTestNow(now()->addMinutes(16));

        // Percobaan ke-7 berhasil
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertRedirect(route('relawan.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_reset_password_end_to_end()
    {
        Notification::fake();

        $user = $this->createRelawan();
        $oldPassword = $user->password;

        // 1. POST /forgot-password
        $response = $this->post('/forgot-password', ['email' => $user->email]);
        $response->assertSessionHas('success');

        // 2. Assert Notification sent dan ambil token (plain) dari notification
        $plainToken = null;
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$plainToken) {
            $plainToken = $notification->token;
            return true;
        });

        // 3. Ambil token dari tabel password_reset_tokens
        $resetRecord = DB::table('password_reset_tokens')->where('email', $user->email)->first();
        $this->assertNotNull($resetRecord);

        // 4. POST /reset-password
        $response = $this->post('/reset-password', [
            'token' => $plainToken,
            'email' => $user->email,
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!'
        ]);
        $response->assertRedirect(route('login'));

        // 5. Assert: password di DB berubah (Hash::check)
        $user->refresh();
        $this->assertTrue(Hash::check('PasswordBaru123!', $user->password));
        $this->assertNotEquals($oldPassword, $user->password);

        // 6. Assert: token dihapus dari password_reset_tokens
        $this->assertNull(DB::table('password_reset_tokens')->where('email', $user->email)->first());

        // 7. POST /login dengan password baru → berhasil
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'PasswordBaru123!'
        ]);
        $response->assertRedirect(route('relawan.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_akses_fitur_relawan_sebelum_verifikasi_email_ditolak()
    {
        // 1. Buat user relawan TANPA verifikasi email
        $user = User::factory()->unverified()->create([
            'peran' => 'relawan',
            'status_akun' => 'aktif', // supaya bisa login
        ]);

        // 2. POST /login → berhasil dapat token / session
        $this->actingAs($user);

        // 3. GET /relawan/profil
        $response = $this->get('/relawan/profil');

        // 4. Assert: redirect ke halaman verifikasi email (302)
        $response->assertStatus(302);
        $response->assertRedirect(route('verification.notice'));
    }
}
