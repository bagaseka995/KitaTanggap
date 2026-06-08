<?php

namespace App\Http\Controllers;

use App\Models\Bencana;
use App\Models\LaporanDistribusi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminLaporanController extends Controller
{
    /**
     * Tampilkan daftar semua laporan distribusi (REQ-24).
     */
    public function index(): View
    {
        $laporanList = LaporanDistribusi::with('bencana')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.laporan_distribusi.index', compact('laporanList'));
    }

    /**
     * Tampilkan form tambah laporan (REQ-24).
     */
    public function create(): View
    {
        // Tampilkan semua bencana (baik yang aktif maupun yang selesai)
        $bencanaList = Bencana::orderBy('nama_bencana', 'asc')->get();

        return view('admin.laporan_distribusi.create', compact('bencanaList'));
    }

    /**
     * Simpan laporan distribusi baru (REQ-24).
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'bencana_id'         => ['required', 'exists:bencana,id'],
            'rincian_penggunaan' => ['required', 'string'],
            'jumlah_disalurkan'  => ['nullable', 'numeric', 'min:0'],
            'bukti_distribusi'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB
        ], [
            'bencana_id.required'         => 'Bencana harus dipilih.',
            'bencana_id.exists'           => 'Bencana yang dipilih tidak valid.',
            'rincian_penggunaan.required' => 'Rincian penggunaan wajib diisi.',
            'bukti_distribusi.file'       => 'Bukti distribusi harus berupa file.',
            'bukti_distribusi.mimes'      => 'Bukti distribusi harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_distribusi.max'        => 'Ukuran bukti distribusi maksimal 5MB.',
        ]);

        $laporan = new LaporanDistribusi();
        $laporan->bencana_id = $request->bencana_id;
        $laporan->rincian_penggunaan = $request->rincian_penggunaan;
        $laporan->jumlah_disalurkan = $request->input('jumlah_disalurkan', 0) ?? 0;
        $laporan->tanggal_laporan = now();

        // Upload file bukti_distribusi
        if ($request->hasFile('bukti_distribusi')) {
            // Simpan file ke storage/app/public/distribusi/
            $path = $request->file('bukti_distribusi')->store('distribusi', 'public');
            
            // Simpan path relatif publik ke kolom bukti_distribusi
            $laporan->bukti_distribusi = 'storage/' . $path;
        }

        $laporan->save();

        return redirect()->route('admin.laporan-distribusi.index')
            ->with('success', 'Laporan distribusi berhasil ditambahkan.');
    }
}
