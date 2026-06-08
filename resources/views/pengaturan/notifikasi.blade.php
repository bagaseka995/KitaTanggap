@extends('layouts.auth')
@section('title', 'Pengaturan Notifikasi')
@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-between">
    {{-- Navbar --}}
    <nav class="bg-[#1F4E79] text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-bold text-lg">KitaTanggap — Pengaturan</span>
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() == url()->current() ? '/dashboard' : url()->previous() }}" class="text-sm opacity-75 hover:opacity-100 transition">Kembali</a>
            </div>
        </div>
    </nav>

    {{-- Main Container --}}
    <div class="max-w-3xl w-full mx-auto px-4 py-12 flex-grow flex flex-col justify-start">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Preferensi Notifikasi</h1>
            <p class="text-gray-500 mt-2">Atur bagaimana Anda ingin menerima peringatan dini terkait bencana di sekitar Anda.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
            <form id="notification-form" class="space-y-6">
                {{-- Lokasi Domisili --}}
                <div>
                    <label for="lokasi_domisili" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Domisili (Wilayah Terdampak)</label>
                    <input type="text" id="lokasi_domisili" name="lokasi_domisili" value="{{ $user->lokasi_domisili }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-brand" placeholder="Misal: Jakarta Selatan" />
                    <p class="text-xs text-gray-500 mt-1">Kami menggunakan lokasi ini untuk mengirimkan peringatan dini jika ada bencana di wilayah tersebut.</p>
                </div>

                <hr class="border-gray-200">

                {{-- Email Notification Toggle --}}
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Notifikasi Email</h3>
                        <p class="text-sm text-gray-500">Terima peringatan dini bencana melalui email ({{ $user->email }}).</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="notif_aktif" name="notif_aktif" class="sr-only peer" {{ $user->notif_aktif ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1F4E79]"></div>
                    </label>
                </div>

                {{-- Push Notification Toggle --}}
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Push Notification (Browser)</h3>
                        <p class="text-sm text-gray-500">Terima notifikasi real-time langsung di perangkat Anda.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        {{-- Secara default kita anggap aktif jika browser mendukung dan pernah allow. Backend FCM logic dipisah. --}}
                        <input type="checkbox" id="fcm_aktif" name="fcm_aktif" class="sr-only peer" {{ $user->fcmTokens->count() > 0 ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1F4E79]"></div>
                    </label>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#1F4E79] text-white font-medium rounded-lg shadow-sm hover:bg-[#163859] transition flex items-center gap-2">
                        <span id="btn-text">Simpan Preferensi</span>
                        <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>

                {{-- Alert Box --}}
                <div id="alert-box" class="hidden p-4 rounded-lg text-sm font-medium mt-4"></div>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('notification-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const alertBox = document.getElementById('alert-box');
        
        btnText.classList.add('hidden');
        btnSpinner.classList.remove('hidden');
        alertBox.classList.add('hidden');
        alertBox.className = 'p-4 rounded-lg text-sm font-medium mt-4 hidden';

        const payload = {
            lokasi_domisili: document.getElementById('lokasi_domisili').value,
            notif_aktif: document.getElementById('notif_aktif').checked,
            fcm_aktif: document.getElementById('fcm_aktif').checked
        };

        try {
            const response = await fetch('{{ route('pengaturan.notifikasi.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok) {
                alertBox.classList.remove('hidden');
                alertBox.classList.add('bg-green-50', 'text-green-800');
                alertBox.innerText = data.message || 'Preferensi berhasil diperbarui!';

                // Handle Push Notification Logic
                if (payload.fcm_aktif) {
                    if (typeof requestNotificationPermission === 'function') {
                        requestNotificationPermission(); // Trigger registration via firebase-messaging.js
                    }
                }
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            alertBox.classList.remove('hidden');
            alertBox.classList.add('bg-red-50', 'text-red-800');
            alertBox.innerText = error.message;
        } finally {
            btnText.classList.remove('hidden');
            btnSpinner.classList.add('hidden');
        }
    });
</script>
@endpush
