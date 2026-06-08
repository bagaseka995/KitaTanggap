@extends('layouts.auth')
@section('title', 'Lupa Password')
@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md animate-fade-up">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#1F4E79] rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Lupa Password?</h1>
            <p class="text-gray-500 text-sm mt-1">Masukkan email Anda untuk mendapatkan link reset password</p>
        </div>
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            @if (session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com"
                           class="input-brand w-full px-4 py-2.5 border rounded-xl text-sm text-gray-900 placeholder-gray-400
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} transition">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="w-full py-3 bg-[#1F4E79] hover:bg-[#163859] text-white font-semibold rounded-xl transition text-sm">
                    Kirim Link Reset Password
                </button>
            </form>
            <p class="mt-5 text-center text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-[#1F4E79] font-semibold hover:underline">← Kembali ke halaman masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
