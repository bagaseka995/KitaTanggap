@extends('layouts.auth')
@section('title', 'Verifikasi Email')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md animate-fade-up">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-5">
                <svg class="w-8 h-8 text-[#1F4E79]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900 mb-2">Verifikasi Email Anda</h1>
            <p class="text-gray-500 text-sm mb-6">
                Kami telah mengirim link verifikasi ke email Anda. Silakan cek inbox atau folder spam.
            </p>
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-3 bg-[#1F4E79] hover:bg-[#163859] text-white font-semibold rounded-xl transition text-sm">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full py-2.5 text-gray-500 hover:text-gray-700 text-sm transition">
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
