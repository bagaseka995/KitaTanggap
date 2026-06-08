<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';

    protected $fillable = [
        'relawan_id', 'bencana_id', 'tanggal_tugas',
        'status_tugas', 'catatan',
    ];

    protected function casts(): array
    {
        return ['tanggal_tugas' => 'date'];
    }

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function relawan(): BelongsTo
    {
        return $this->belongsTo(Relawan::class);
    }

    public function bencana(): BelongsTo
    {
        return $this->belongsTo(Bencana::class);
    }

    public function sertifikat(): HasOne
    {
        return $this->hasOne(Sertifikat::class);
    }

    /* ─── Accessor ───────────────────────────────────────────── */

    public function getWarnaStatusAttribute(): string
    {
        return match ($this->status_tugas) {
            'ditugaskan'  => '#3B82F6',
            'berlangsung' => '#F97316',
            'selesai'     => '#22C55E',
            'dibatalkan'  => '#6B7280',
            default       => '#6B7280',
        };
    }
}
