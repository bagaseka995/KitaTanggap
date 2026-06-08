<?php

namespace App\Http\Controllers;

use App\Mail\PenugasanRelawanMail;
use App\Models\Bencana;
use App\Models\Penugasan;
use App\Models\Relawan;
use App\Services\SertifikatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PenugasanController extends Controller
{
    /* ═══════════════════════════════════════════════════════════
     │  ADMIN: MANAJEMEN PENUGASAN (REQ-15, REQ-16)
     │  Semua method admin dilindungi middleware role:admin
     ══════════════════════════════════════════════════════════ */

    /** GET /admin/penugasan — Tampilkan halaman dashboard penugasan */
    public function adminIndex(): View
    {
        // Ambil bencana aktif untuk dropdown
        $bencana = Bencana::aktif()->orderBy('nama_bencana')->get();

        // Ambil relawan terverifikasi yang tersedia (ketersediaan=true)
        $relawan = Relawan::where('status_verifikasi', 'terverifikasi')
            ->where('ketersediaan', true)
            ->with('user')
            ->get()
            ->sortBy(fn ($r) => $r->user->nama_lengkap)
            ->values();

        return view('admin.penugasan.index', compact('bencana', 'relawan'));
    }

    /** GET /api/penugasan — List penugasan dengan filter & pagination */
    public function index(Request $request): JsonResponse
    {
        $query = Penugasan::with(['relawan.user:id,nama_lengkap,email,no_telepon', 'bencana:id,nama_bencana,lokasi,status_siaga'])
            ->orderByDesc('created_at');

        // Filter bencana
        if ($request->filled('bencana_id')) {
            $query->where('bencana_id', $request->bencana_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_tugas', $request->status);
        }

        // Filter relawan
        if ($request->filled('relawan_id')) {
            $query->where('relawan_id', $request->relawan_id);
        }

        $penugasan = $query->paginate(10);

        // Tambah accessor warna_status
        $penugasan->getCollection()->transform(fn ($p) => array_merge($p->toArray(), [
            'warna_status' => $p->warna_status,
        ]));

        return response()->json($penugasan);
    }

    /** POST /api/penugasan — Tambah penugasan baru & kirim notifikasi */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'relawan_id'    => ['required', 'exists:relawan,id'],
            'bencana_id'    => ['required', 'exists:bencana,id'],
            'tanggal_tugas' => ['required', 'date', 'after_or_equal:today'],
            'catatan'       => ['nullable', 'string', 'max:500'],
        ], [
            'relawan_id.required'    => 'Relawan wajib dipilih.',
            'relawan_id.exists'      => 'Data relawan tidak ditemukan.',
            'bencana_id.required'    => 'Bencana wajib dipilih.',
            'bencana_id.exists'      => 'Data bencana tidak ditemukan.',
            'tanggal_tugas.required' => 'Tanggal tugas wajib diisi.',
            'tanggal_tugas.date'     => 'Format tanggal tugas tidak valid.',
            'tanggal_tugas.after_or_equal' => 'Tanggal tugas tidak boleh sebelum hari ini.',
            'catatan.max'            => 'Catatan maksimal 500 karakter.',
        ]);

        $relawan = Relawan::with('user')->findOrFail($request->relawan_id);
        $bencana = Bencana::findOrFail($request->bencana_id);

        // Cek verifikasi relawan
        if ($relawan->status_verifikasi !== 'terverifikasi') {
            return response()->json([
                'message' => 'Relawan belum terverifikasi',
            ], 422);
        }

        // Cek status aktif bencana
        if (!$bencana->status_aktif) {
            return response()->json([
                'message' => 'Bencana sudah tidak aktif',
            ], 422);
        }

        // Cek duplikasi penugasan aktif (bukan dibatalkan)
        $exists = Penugasan::where('relawan_id', $request->relawan_id)
            ->where('bencana_id', $request->bencana_id)
            ->where('status_tugas', '!=', 'dibatalkan')
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Relawan sudah ditugaskan di bencana ini',
            ], 422);
        }

        // Simpan penugasan
        $penugasan = Penugasan::create([
            'relawan_id'    => $request->relawan_id,
            'bencana_id'    => $request->bencana_id,
            'tanggal_tugas' => $request->tanggal_tugas,
            'catatan'       => $request->catatan,
            'status_tugas'  => 'ditugaskan', // default
        ]);

        // Kirim email notifikasi (REQ-16)
        try {
            Mail::to($relawan->user->email)->send(new PenugasanRelawanMail($penugasan));
        } catch (\Exception $e) {
            // Log error tetapi tidak menggagalkan response API
            \Log::warning("Gagal mengirim email penugasan relawan #{$penugasan->id}: " . $e->getMessage());
        }

        return response()->json([
            'status'  => 'success',
            'message' => "Relawan {$relawan->user->nama_lengkap} berhasil ditugaskan ke {$bencana->nama_bencana}.",
            'data'    => $penugasan,
        ]);
    }

    /** PATCH /api/penugasan/{id}/status — Update status penugasan (admin) */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:berlangsung,dibatalkan'],
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $penugasan = Penugasan::with(['relawan.user', 'bencana'])->findOrFail($id);
        $penugasan->update(['status_tugas' => $request->status]);

        $statusLabel = match ($request->status) {
            'berlangsung' => 'dimulai',
            'dibatalkan'  => 'dibatalkan',
        };

        return response()->json([
            'status'  => 'success',
            'message' => "Misi relawan {$penugasan->relawan->user->nama_lengkap} berhasil {$statusLabel}.",
            'data'    => array_merge($penugasan->fresh()->toArray(), [
                'warna_status' => $penugasan->fresh()->warna_status,
            ]),
        ]);
    }

    /** PATCH /api/penugasan/{id}/selesai — Selesaikan misi relawan & generate sertifikat (admin) */
    public function selesai(int $id, SertifikatService $sertifikatService): JsonResponse
    {
        $penugasan = Penugasan::with(['relawan.user', 'bencana'])->findOrFail($id);

        if ($penugasan->status_tugas === 'selesai') {
            return response()->json([
                'message' => 'Misi ini sudah diselesaikan sebelumnya.',
            ], 422);
        }

        // Update status_tugas = 'selesai'
        $penugasan->update(['status_tugas' => 'selesai']);

        // Generate sertifikat digital otomatis (REQ-18)
        try {
            $sertifikat = $sertifikatService->generate($id);
            $kodeSertifikat = $sertifikat->kode_sertifikat;
        } catch (\Exception $e) {
            \Log::error("Gagal generate sertifikat untuk penugasan #{$id}: " . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Misi diselesaikan, namun gagal membuat sertifikat digital: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status'          => 'success',
            'message'         => "Misi relawan {$penugasan->relawan->user->nama_lengkap} berhasil diselesaikan. Sertifikat digital {$kodeSertifikat} telah diterbitkan dan dikirim ke email.",
            'kode_sertifikat' => $kodeSertifikat,
            'data'            => array_merge($penugasan->fresh()->toArray(), [
                'warna_status' => $penugasan->fresh()->warna_status,
            ]),
        ]);
    }

    /* ═══════════════════════════════════════════════════════════
     │  RELAWAN: RIWAYAT MISI (REQ-17)
     │  Semua method relawan dilindungi middleware role:relawan
     ══════════════════════════════════════════════════════════ */

    /** GET /relawan/riwayat — Tampilkan halaman riwayat misi relawan */
    public function riwayatIndex(): View
    {
        return view('relawan.riwayat');
    }

    /** GET /api/relawan/riwayat — List riwayat misi relawan login */
    public function riwayat(): JsonResponse
    {
        $relawan = auth()->user()->relawan;

        if (!$relawan) {
            return response()->json([
                'data' => [],
            ]);
        }

        $riwayat = Penugasan::where('relawan_id', $relawan->id)
            ->with(['bencana:id,nama_bencana,lokasi,status_siaga', 'sertifikat'])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($p) => array_merge($p->toArray(), [
                'warna_status' => $p->warna_status,
            ]));

        return response()->json([
            'data' => $riwayat,
        ]);
    }
}
