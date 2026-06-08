<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAffectedUsersJob;
use App\Models\Bencana;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BencanaController extends Controller
{
    /**
     * GET /peta — Halaman peta interaktif publik (REQ-08, REQ-10).
     * Dapat diakses tanpa login.
     */
    public function peta(): View
    {
        return view('publik.peta');
    }

    /**
     * GET /api/bencana/peta — JSON untuk Leaflet (REQ-08, REQ-09).
     * Mengembalikan SEMUA bencana aktif beserta warna marker.
     * Publik, tanpa middleware auth.
     */
    public function petaApi(): JsonResponse
    {
        $bencana = Bencana::aktif()
            ->orderByRaw("FIELD(status_siaga,'awas','siaga','waspada')")
            ->get(['id', 'nama_bencana', 'jenis_bencana', 'lokasi',
                   'latitude', 'longitude', 'status_siaga',
                   'tanggal_kejadian', 'deskripsi'])
            ->map(fn ($b) => [
                'id'               => $b->id,
                'nama_bencana'     => $b->nama_bencana,
                'jenis_bencana'    => $b->jenis_bencana,
                'lokasi'           => $b->lokasi,
                'latitude'         => (float) $b->latitude,
                'longitude'        => (float) $b->longitude,
                'status_siaga'     => $b->status_siaga,
                'warna_siaga'      => $b->warna_siaga,       // accessor
                'label_siaga'      => $b->label_siaga,       // accessor
                'tanggal_kejadian' => $b->tanggal_kejadian?->format('d M Y'),
                'deskripsi'        => $b->deskripsi,
            ]);

        return response()->json($bencana);
    }

    /**
     * GET /api/bencana — Daftar bencana dengan filter (REQ-11).
     * Publik, support query: ?lokasi=&jenis=&siaga=&dari=&sampai=
     */
    public function index(Request $request): JsonResponse
    {
        $bencana = Bencana::aktif()
            ->lokasi($request->lokasi)
            ->jenis($request->jenis)
            ->siaga($request->siaga)
            ->rentangTanggal($request->dari, $request->sampai)
            ->orderByDesc('tanggal_kejadian')
            ->get(['id', 'nama_bencana', 'jenis_bencana', 'lokasi',
                   'latitude', 'longitude', 'status_siaga',
                   'tanggal_kejadian', 'deskripsi', 'status_aktif'])
            ->map(fn ($b) => array_merge($b->toArray(), [
                'warna_siaga'      => $b->warna_siaga,
                'label_siaga'      => $b->label_siaga,
                'tanggal_kejadian' => $b->tanggal_kejadian?->format('d M Y'),
            ]));

        return response()->json([
            'total' => $bencana->count(),
            'data'  => $bencana,
        ]);
    }

    /**
     * GET /api/bencana/{id} — Detail satu bencana (publik).
     */
    public function show(int $id): JsonResponse
    {
        $bencana = Bencana::findOrFail($id);

        return response()->json(array_merge($bencana->toArray(), [
            'warna_siaga'      => $bencana->warna_siaga,
            'label_siaga'      => $bencana->label_siaga,
            'tanggal_kejadian' => $bencana->tanggal_kejadian?->format('d M Y'),
        ]));
    }

    /**
     * POST /api/admin/bencana — Tambah Bencana Baru (Admin)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_bencana'     => 'required|string|max:255',
            'jenis_bencana'    => 'required|string|max:100',
            'lokasi'           => 'required|string|max:255',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'tanggal_kejadian' => 'required|date',
            'status_siaga'     => 'required|in:waspada,siaga,awas',
            'deskripsi'        => 'required|string',
            'target_dana'      => 'nullable|numeric|min:0',
        ]);

        $bencana = Bencana::create(array_merge($validated, [
            'status_aktif' => true,
            'admin_id'     => auth()->id(),
        ]));

        // REQ-25: Kirim notifikasi email ke user di wilayah terdampak
        NotifyAffectedUsersJob::dispatch($bencana);

        return response()->json([
            'message' => 'Bencana berhasil ditambahkan',
            'data'    => $bencana,
        ], 201);
    }
}
