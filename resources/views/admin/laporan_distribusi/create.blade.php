@extends('layouts.auth')
@section('title', 'Dashboard Admin — Tambah Laporan')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-between">
    {{-- Navbar --}}
    <nav class="bg-[#1F4E79] text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg hover:opacity-90 transition">
                    KitaTanggap — Admin
                </a>
                <div class="hidden md:flex gap-3 text-sm">
                    <a href="{{ route('admin.relawan.index') }}" class="px-3 py-1 rounded hover:bg-[#2E75B6]/50 transition">
                        Manajemen Relawan
                    </a>
                    <a href="{{ route('admin.penugasan.index') }}" class="px-3 py-1 rounded hover:bg-[#2E75B6]/50 transition">
                        Penugasan Relawan
                    </a>
                    <a href="{{ route('admin.laporan-distribusi.index') }}" class="px-3 py-1 rounded bg-[#2E75B6] font-medium transition">
                        Laporan Distribusi
                    </a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm opacity-75 hover:opacity-100 transition">Keluar</button>
            </form>
        </div>
    </nav>

    {{-- Main Container --}}
    <div class="max-w-3xl w-full mx-auto px-4 py-8 flex-grow">
        {{-- Navigation for Mobile --}}
        <div class="flex md:hidden gap-2 mb-6 text-sm">
            <a href="{{ route('admin.relawan.index') }}" class="flex-1 text-center py-2 rounded-lg bg-white border text-gray-700 hover:bg-gray-50">
                Relawan
            </a>
            <a href="{{ route('admin.penugasan.index') }}" class="flex-1 text-center py-2 rounded-lg bg-white border text-gray-700 hover:bg-gray-50">
                Penugasan
            </a>
            <a href="{{ route('admin.laporan-distribusi.index') }}" class="flex-1 text-center py-2 rounded-lg bg-[#1F4E79] text-white font-medium shadow-sm">
                Laporan
            </a>
        </div>

        {{-- Breadcrumbs / Back button --}}
        <div class="mb-6">
            <a href="{{ route('admin.laporan-distribusi.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[#1F4E79] hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Laporan
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Buat Laporan Distribusi Baru</h2>
            <p class="text-sm text-gray-400 mb-6 border-b border-gray-100 pb-4">Isi rincian penggunaan dana donasi kebencanaan secara terperinci.</p>

            <form method="POST" action="{{ route('admin.laporan-distribusi.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Bencana --}}
                <div>
                    <label for="bencana_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Pilih Bencana <span class="text-red-500">*</span>
                    </label>
                    <select id="bencana_id" name="bencana_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#1F4E79] focus:ring-2 focus:ring-[#1F4E79]/20 transition bg-white {{ $errors->has('bencana_id') ? 'border-red-400 bg-red-50' : '' }}">
                        <option value="" disabled selected>— Pilih Bencana —</option>
                        @foreach($bencanaList as $bencana)
                            <option value="{{ $bencana->id }}" {{ old('bencana_id') == $bencana->id ? 'selected' : '' }}>
                                {{ $bencana->nama_bencana }} ({{ $bencana->lokasi }})
                            </option>
                        @endforeach
                    </select>
                    @error('bencana_id')
                        <p class="mt-1.5 text-xs text-red-650 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jumlah Disalurkan --}}
                <div>
                    <label for="jumlah_disalurkan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jumlah Dana yang Disalurkan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">
                            Rp
                        </span>
                        <input id="jumlah_disalurkan" name="jumlah_disalurkan" type="number" 
                               value="{{ old('jumlah_disalurkan') }}" min="0" placeholder="Contoh: 15000000"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#1F4E79] focus:ring-2 focus:ring-[#1F4E79]/20 transition {{ $errors->has('jumlah_disalurkan') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Masukkan nominal rupiah tanpa titik/koma. Nilai default adalah 0.</p>
                    @error('jumlah_disalurkan')
                        <p class="mt-1.5 text-xs text-red-650 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Rincian Penggunaan --}}
                <div>
                    <label for="rincian_penggunaan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Rincian Penggunaan Dana <span class="text-red-500">*</span>
                    </label>
                    <textarea id="rincian_penggunaan" name="rincian_penggunaan" rows="5" required
                              placeholder="Contoh: Penyaluran logistik tahap 1 berupa 200 dus mi instan, 50 tenda darurat, obat-obatan, dan biaya operasional penugasan relawan UNSOED..."
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#1F4E79] focus:ring-2 focus:ring-[#1F4E79]/20 transition {{ $errors->has('rincian_penggunaan') ? 'border-red-400 bg-red-50' : '' }}">{{ old('rincian_penggunaan') }}</textarea>
                    @error('rincian_penggunaan')
                        <p class="mt-1.5 text-xs text-red-650 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Upload Bukti --}}
                <div>
                    <label for="bukti_distribusi" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Unggah Bukti Distribusi <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input id="bukti_distribusi" name="bukti_distribusi" type="file" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#1F4E79] hover:file:bg-blue-100 border border-gray-300 rounded-xl p-2 bg-gray-50 transition {{ $errors->has('bukti_distribusi') ? 'border-red-400 bg-red-50' : '' }}">
                    <p class="text-[10px] text-gray-450 mt-1">Format dokumen yang diizinkan: PDF, JPG, JPEG, PNG (Ukuran maksimal 5MB).</p>
                    @error('bukti_distribusi')
                        <p class="mt-1.5 text-xs text-red-650 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.laporan-distribusi.index') }}" 
                       class="px-5 py-2.5 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl text-sm transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-[#1F4E79] hover:bg-[#163859] text-white font-semibold rounded-xl text-sm transition shadow-sm">
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-400 mt-8">
        <p>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
    </footer>
</div>
@endsection
