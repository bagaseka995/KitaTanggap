@extends('layouts.auth')
@section('title', 'Dashboard Admin')
@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-between">
    {{-- Navbar --}}
    <nav class="bg-[#1F4E79] text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-bold text-lg">KitaTanggap — Admin</span>
            <div class="flex items-center gap-4">
                <a href="{{ route('pengaturan.notifikasi') }}" class="text-sm opacity-75 hover:opacity-100 transition">Pengaturan</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="text-sm opacity-75 hover:opacity-100 transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Container --}}
    <div class="max-w-5xl w-full mx-auto px-4 py-12 flex-grow flex flex-col justify-center items-center">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Portal Administrasi KitaTanggap</h1>
            <p class="text-gray-500 mt-2">Selamat datang kembali, <strong>{{ auth()->user()->nama_lengkap }}</strong>. Pilih menu di bawah ini untuk memulai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
            {{-- Card 1: Manajemen Relawan --}}
            <a href="{{ route('admin.relawan.index') }}" class="group bg-white p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#2E75B6] transition duration-200 text-left flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1F4E79] flex items-center justify-center mb-5 group-hover:bg-[#1F4E79] group-hover:text-white transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-950 group-hover:text-[#1F4E79] transition">Manajemen Relawan</h2>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">Verifikasi atau tolak pendaftaran relawan baru, dan pantau daftar profil keahlian serta domisili relawan aktif.</p>
                </div>
                <div class="mt-6 text-sm font-semibold text-[#1F4E79] flex items-center gap-1">
                    Buka Dashboard Relawan →
                </div>
            </a>

            {{-- Card 2: Penugasan Relawan --}}
            <a href="{{ route('admin.penugasan.index') }}" class="group bg-white p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#2E75B6] transition duration-200 text-left flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#C55A11] flex items-center justify-center mb-5 group-hover:bg-[#C55A11] group-hover:text-white transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-950 group-hover:text-[#C55A11] transition">Penugasan Relawan</h2>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">Tugaskan relawan terverifikasi ke bencana aktif, pantau misi berjalan, dan selesaikan misi untuk menerbitkan sertifikat digital otomatis.</p>
                </div>
                <div class="mt-6 text-sm font-semibold text-[#C55A11] flex items-center gap-1">
                    Buka Penugasan Relawan →
                </div>
            </a>

            {{-- Card 3: Laporan Distribusi --}}
            <a href="{{ route('admin.laporan-distribusi.index') }}" class="group bg-white p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#2E75B6] transition duration-200 text-left flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-5 group-hover:bg-green-600 group-hover:text-white transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-950 group-hover:text-green-600 transition">Laporan Distribusi</h2>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">Catat penggunaan dana donasi, rincian logistik, dan unggah bukti penyaluran bantuan ke halaman transparansi publik.</p>
                </div>
                <div class="mt-6 text-sm font-semibold text-green-600 flex items-center gap-1">
                    Buka Laporan Distribusi →
                </div>
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
    </footer>
</div>
@endsection
