<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Relawan extends Model
{
    use HasFactory;

    protected $table = 'relawan';

    protected $fillable = [
        'user_id', 'keahlian', 'pengalaman',
        'lokasi_domisili', 'ketersediaan', 'status_verifikasi',
    ];

    protected function casts(): array
    {
        return ['ketersediaan' => 'boolean'];
    }

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penugasan(): HasMany
    {
        return $this->hasMany(Penugasan::class);
    }

    /* ─── Accessor ───────────────────────────────────────────── */

    /** Warna badge status verifikasi */
    public function getWarnaStatusAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'terverifikasi' => '#22C55E',
            'ditolak'       => '#EF4444',
            default         => '#EAB308',   // pending
        };
    }

    /** Keahlian sebagai array */
    public function getKeahlianArrayAttribute(): array
    {
        if (!$this->keahlian) return [];
        return array_map('trim', explode(',', $this->keahlian));
    }

    /* ─── Scopes ─────────────────────────────────────────────── */

    public function scopeStatus($query, ?string $status)
    {
        if ($status) $query->where('status_verifikasi', $status);
        return $query;
    }

    public function scopeKeahlian($query, ?string $keahlian)
    {
        if ($keahlian) $query->where('keahlian', 'like', "%{$keahlian}%");
        return $query;
    }

    public function scopeLokasi($query, ?string $lokasi)
    {
        if ($lokasi) $query->where('lokasi_domisili', 'like', "%{$lokasi}%");
        return $query;
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status_verifikasi', 'terverifikasi');
    }
}
