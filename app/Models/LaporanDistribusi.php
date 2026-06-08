<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanDistribusi extends Model
{
    use HasFactory;

    protected $table = 'laporan_distribusi';

    protected $fillable = [
        'bencana_id',
        'rincian_penggunaan',
        'bukti_distribusi',
        'jumlah_disalurkan',
        'tanggal_laporan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_disalurkan' => 'decimal:2',
            'tanggal_laporan'   => 'datetime',
        ];
    }

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function bencana(): BelongsTo
    {
        return $this->belongsTo(Bencana::class);
    }

    /* ─── Accessor ───────────────────────────────────────────── */

    /** Format jumlah disalurkan ke Rupiah */
    public function getJumlahFormattedAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->jumlah_disalurkan, 0, ',', '.');
    }
}
