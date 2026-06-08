<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'bencana_id',
        'user_id',
        'kode_transaksi',
        'nama_donatur',
        'email_donatur',
        'nominal',
        'pesan',
        'metode_pembayaran',
        'status_bayar',
        'snap_token',
        'midtrans_transaction_id',
        'bukti_transfer',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
        ];
    }

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function bencana(): BelongsTo
    {
        return $this->belongsTo(Bencana::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ─── Scopes ──────────────────────────────────────────────── */

    /** Hanya donasi yang sudah sukses */
    public function scopeSukses($query)
    {
        return $query->where('status_bayar', 'sukses');
    }

    /* ─── Accessor ───────────────────────────────────────────── */

    /** Format nominal ke Rupiah */
    public function getNominalFormattedAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->nominal, 0, ',', '.');
    }

    /** Warna badge berdasarkan status pembayaran */
    public function getWarnaStatusAttribute(): string
    {
        return match ($this->status_bayar) {
            'pending' => '#F59E0B',
            'sukses'  => '#22C55E',
            'gagal'   => '#EF4444',
            default   => '#6B7280',
        };
    }

    /** Label metode pembayaran */
    public function getLabelMetodeAttribute(): string
    {
        return match ($this->metode_pembayaran) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet'      => 'E-Wallet',
            'kartu_kredit'  => 'Kartu Kredit',
            default         => '-',
        };
    }
}
