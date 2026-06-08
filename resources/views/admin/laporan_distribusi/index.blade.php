@extends('layouts.auth')
@section('title', 'Dashboard Admin — Laporan Distribusi')

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
    <div class="max-w-6xl w-full mx-auto px-4 py-8 flex-grow">
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

        {{-- Success Flash Alert --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm animate-fade-up">
                <svg class="w-5 h-5 mt-0.5 shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-950 tracking-tight">Laporan Distribusi Bantuan & Penggunaan Dana</h1>
                <p class="text-sm text-gray-500 mt-1">Catat dan kelola riwayat penggunaan dana untuk transparansi donasi kepada donatur.</p>
            </div>
            <a href="{{ route('admin.laporan-distribusi.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-[#1F4E79] hover:bg-[#163859] text-white text-sm font-semibold rounded-xl transition shadow-sm gap-1.5 self-start sm:self-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Laporan Baru
            </a>
        </div>

        {{-- Table Card --}}
        @if($laporanList->isEmpty())
            <div class="text-center py-16 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="w-16 h-16 bg-blue-50 text-[#1F4E79] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Belum Ada Laporan Distribusi</h3>
                <p class="text-sm text-gray-400 mt-1 max-w-md mx-auto">
                    Mulai catat laporan penggunaan dana donasi kebencanaan agar donatur dapat memantau transparansi penyaluran bantuan.
                </p>
                <div class="mt-6 flex justify-center gap-3">
                    <a href="{{ route('admin.laporan-distribusi.create') }}" class="px-5 py-2.5 bg-[#1F4E79] hover:bg-[#163859] text-white text-sm font-semibold rounded-xl transition shadow-sm">
                        Buat Laporan Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
                {{-- Desktop View Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="p-4 pl-6 w-16">No</th>
                                <th class="p-4">Bencana</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4 text-right">Jumlah Disalurkan</th>
                                <th class="p-4">Rincian Penggunaan</th>
                                <th class="p-4 pr-6 w-36">Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @foreach($laporanList as $idx => $laporan)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 pl-6 text-gray-400 font-semibold">
                                        {{ $laporanList->firstItem() + $idx }}
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 leading-tight">
                                            {{ $laporan->bencana->nama_bencana }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            {{ $laporan->bencana->lokasi }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-xs font-medium text-gray-500 whitespace-nowrap">
                                        {{ $laporan->tanggal_laporan?->format('d M Y') ?? $laporan->created_at->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-right font-extrabold text-[#1F4E79]">
                                        {{ $laporan->jumlah_formatted }}
                                    </td>
                                    <td class="p-4 max-w-xs text-gray-650 truncate-cell" title="{{ $laporan->rincian_penggunaan }}">
                                        <div class="line-clamp-2 text-xs leading-relaxed">
                                            {{ $laporan->rincian_penggunaan }}
                                        </div>
                                    </td>
                                    <td class="p-4 pr-6 whitespace-nowrap">
                                        @if($laporan->bukti_distribusi)
                                            <a href="{{ asset($laporan->bukti_distribusi) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-[#1F4E79] hover:bg-blue-100 text-xs font-bold rounded-lg border border-blue-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-450 italic">Tidak ada bukti</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View Cards --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($laporanList as $laporan)
                        <div class="p-5 hover:bg-gray-50/50 transition">
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    {{ $laporan->tanggal_laporan?->format('d M Y') ?? $laporan->created_at->format('d M Y') }}
                                </span>
                                @if($laporan->bukti_distribusi)
                                    <a href="{{ asset($laporan->bukti_distribusi) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#1F4E79] hover:underline">
                                        Lihat Bukti →
                                    </a>
                                @endif
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 leading-tight mb-2">
                                {{ $laporan->bencana->nama_bencana }}
                            </h3>
                            <p class="text-xs text-gray-650 mb-3 bg-gray-50 p-2.5 rounded-lg border border-gray-100 leading-relaxed line-clamp-3">
                                {{ $laporan->rincian_penggunaan }}
                            </p>
                            <div class="flex items-center justify-between text-xs pt-1 border-t border-dashed border-gray-100">
                                <span class="text-gray-400">Jumlah Disalurkan</span>
                                <span class="font-extrabold text-[#1F4E79]">{{ $laporan->jumlah_formatted }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 px-2">
                {{ $laporanList->links() }}
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-400 mt-8">
        <p>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
    </footer>
</div>
@endsection
