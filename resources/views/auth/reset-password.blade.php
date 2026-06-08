@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md animate-fade-up">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#1F4E79] rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Password Baru</h1>
            <p class="text-gray-500 text-sm mt-1">Pastikan password baru Anda aman</p>
        </div>
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8" x-data="{ show: false }">
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm">
                    @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="input-brand w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm transition">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input id="password" name="password" :type="show ? 'text' : 'password'" required
                               placeholder="Min. 8 karakter, huruf & angka"
                               class="input-brand w-full px-4 py-2.5 pr-11 border border-gray-300 rounded-xl text-sm transition">
                        <button type="button" @click="show=!show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required
                           class="input-brand w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm transition">
                </div>
                <button type="submit"
                        class="w-full py-3 bg-[#1F4E79] hover:bg-[#163859] text-white font-semibold rounded-xl transition text-sm">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
