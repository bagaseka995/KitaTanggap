<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'penugasan_id', 'kode_sertifikat', 'tanggal_terbit', 'file_path',
    ];

    protected function casts(): array
    {
        return ['tanggal_terbit' => 'date'];
    }

    public function penugasan(): BelongsTo
    {
        return $this->belongsTo(Penugasan::class);
    }
}
