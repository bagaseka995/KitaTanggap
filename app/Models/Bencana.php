<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bencana extends Model
{
    use HasFactory;

    protected $table = 'bencana';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_bencana',
        'jenis_bencana',
        'lokasi',
        'latitude',
        'longitude',
        'tanggal_kejadian',
        'status_siaga',
        'deskripsi',
        'status_aktif',
        'target_dana',
        'admin_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kejadian' => 'date',
            'status_aktif'     => 'boolean',
            'target_dana'      => 'decimal:2',
            'latitude'         => 'decimal:7',
            'longitude'        => 'decimal:7',
        ];
    }

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /** Donasi yang masuk untuk bencana ini (REQ-19) */
    public function donasi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donasi::class);
    }

    /** Laporan distribusi dana untuk bencana ini (REQ-22) */
    public function laporanDistribusi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LaporanDistribusi::class);
    }

    /* ─── Accessor Warna Siaga (REQ-09) ─────────────────────── */

    /**
     * Warna marker Leaflet berdasarkan status siaga.
     *   waspada → #EAB308 (kuning)
     *   siaga   → #F97316 (oranye)
     *   awas    → #EF4444 (merah)
     *
     * Akses via $bencana->warna_siaga
     */
    public function getWarnaSiagaAttribute(): string
    {
        return match ($this->status_siaga) {
            'waspada' => '#EAB308',
            'siaga'   => '#F97316',
            'awas'    => '#EF4444',
            default   => '#6B7280',
        };
    }

    /**
     * Label status siaga dalam Bahasa Indonesia.
     */
    public function getLabelSiagaAttribute(): string
    {
        return match ($this->status_siaga) {
            'waspada' => 'Waspada',
            'siaga'   => 'Siaga',
            'awas'    => 'Awas',
            default   => '-',
        };
    }

    /* ─── Scopes ─────────────────────────────────────────────── */

    /** Hanya bencana aktif (REQ-10) */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /** Filter lokasi (REQ-11) */
    public function scopeLokasi($query, ?string $lokasi)
    {
        if ($lokasi) {
            $query->where('lokasi', 'like', "%{$lokasi}%");
        }
        return $query;
    }

    /** Filter jenis bencana (REQ-11) */
    public function scopeJenis($query, ?string $jenis)
    {
        if ($jenis) {
            $query->where('jenis_bencana', $jenis);
        }
        return $query;
    }

    /** Filter status siaga (REQ-11) */
    public function scopeSiaga($query, ?string $siaga)
    {
        if ($siaga) {
            $query->where('status_siaga', $siaga);
        }
        return $query;
    }

    /** Filter rentang tanggal (REQ-11) */
    public function scopeRentangTanggal($query, ?string $dari, ?string $sampai)
    {
        if ($dari) {
            $query->whereDate('tanggal_kejadian', '>=', $dari);
        }
        if ($sampai) {
            $query->whereDate('tanggal_kejadian', '<=', $sampai);
        }
        return $query;
    }
}
