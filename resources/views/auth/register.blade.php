@extends('layouts.auth')

@section('title', 'Daftar Akun')
@section('meta_description', 'Daftar sebagai relawan atau donatur di KitaTanggap.')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">

    {{-- Latar dekorasi --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md animate-fade-up">

        {{-- Logo & heading --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl shadow-lg mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Bergabung dengan KitaTanggap</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun untuk mulai berkontribusi</p>
        </div>

        {{-- Kartu form --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8"
             x-data="registerForm()">

            {{-- Flash success --}}
            @if (session('success'))
                <div class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-4">
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input id="nama_lengkap" name="nama_lengkap" type="text"
                           value="{{ old('nama_lengkap') }}"
                           autocomplete="name" required
                           placeholder="Masukkan nama lengkap Anda"
                           class="input-brand w-full px-4 py-2.5 border rounded-xl text-sm text-gray-900 placeholder-gray-400
                                  {{ $errors->has('nama_lengkap') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                                  transition focus:border-primary">
                    @error('nama_lengkap')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           autocomplete="email" required
                           placeholder="nama@email.com"
                           class="input-brand w-full px-4 py-2.5 border rounded-xl text-sm text-gray-900 placeholder-gray-400
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                                  transition focus:border-primary">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- No Telepon --}}
                <div class="mb-4">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1.5">
                        No. Telepon <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input id="no_telepon" name="no_telepon" type="tel"
                           value="{{ old('no_telepon') }}"
                           placeholder="08xxxxxxxxxx"
                           class="input-brand w-full px-4 py-2.5 border rounded-xl text-sm text-gray-900 placeholder-gray-400
                                  {{ $errors->has('no_telepon') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                                  transition focus:border-primary">
                    @error('no_telepon')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Peran --}}
                <div class="mb-4">
                    <label for="peran" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Daftar Sebagai <span class="text-red-500">*</span>
                    </label>
                    <select id="peran" name="peran" required
                            class="input-brand w-full px-4 py-2.5 border rounded-xl text-sm text-gray-900
                                   {{ $errors->has('peran') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                                   transition focus:border-primary bg-white">
                        <option value="" disabled {{ old('peran') ? '' : 'selected' }}>— Pilih peran —</option>
                        <option value="relawan" {{ old('peran') === 'relawan' ? 'selected' : '' }}>
                            🤝 Relawan — Saya ingin membantu di lapangan
                        </option>
                        <option value="donatur" {{ old('peran') === 'donatur' ? 'selected' : '' }}>
                            💙 Donatur — Saya ingin berdonasi
                        </option>
                    </select>
                    @error('peran')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" name="password"
                               :type="showPassword ? 'text' : 'password'"
                               @input="checkStrength($event.target.value)"
                               autocomplete="new-password" required
                               placeholder="Min. 8 karakter, huruf & angka"
                               class="input-brand w-full px-4 py-2.5 pr-11 border rounded-xl text-sm text-gray-900 placeholder-gray-400
                                      {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                                      transition focus:border-primary">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Password strength indicator --}}
                    <div class="mt-2" x-show="password.length > 0" x-cloak>
                        <div class="flex gap-1 mb-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                                <div class="strength-bar h-full rounded-full"
                                     :style="{ width: strength >= 1 ? '100%' : '0%', backgroundColor: strengthColor }"></div>
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                                <div class="strength-bar h-full rounded-full"
                                     :style="{ width: strength >= 2 ? '100%' : '0%', backgroundColor: strengthColor }"></div>
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                                <div class="strength-bar h-full rounded-full"
                                     :style="{ width: strength >= 3 ? '100%' : '0%', backgroundColor: strengthColor }"></div>
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                                <div class="strength-bar h-full rounded-full"
                                     :style="{ width: strength >= 4 ? '100%' : '0%', backgroundColor: strengthColor }"></div>
                            </div>
                        </div>
                        <p class="text-xs" :style="{ color: strengthColor }" x-text="strengthLabel"></p>
                    </div>

                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation"
                               :type="showConfirm ? 'text' : 'password'"
                               @input="checkMatch($event.target.value)"
                               autocomplete="new-password" required
                               placeholder="Ulangi password Anda"
                               class="input-brand w-full px-4 py-2.5 pr-11 border rounded-xl text-sm text-gray-900 placeholder-gray-400 border-gray-300 transition focus:border-primary">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p x-show="matchMsg !== ''" x-cloak
                       class="mt-1.5 text-xs flex items-center gap-1"
                       :class="matchOk ? 'text-green-600' : 'text-red-600'"
                       x-text="matchMsg"></p>
                </div>

                {{-- Tombol Daftar --}}
                <button type="submit"
                        class="w-full py-3 px-6 bg-[#1F4E79] hover:bg-[#163859] active:scale-[0.98] text-white font-semibold rounded-xl
                               transition duration-150 shadow-md hover:shadow-lg text-sm tracking-wide">
                    Daftar Sekarang
                </button>
            </form>

            {{-- Link ke login --}}
            <p class="mt-5 text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#1F4E79] font-semibold hover:underline">Masuk di sini</a>
            </p>
        </div>

        {{-- Footer note --}}
        <p class="mt-6 text-center text-xs text-gray-400">
            © {{ date('Y') }} KitaTanggap — Universitas Jenderal Soedirman
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function registerForm() {
    return {
        showPassword: false,
        showConfirm:  false,
        password:     '',
        strength:     0,
        strengthColor: '#9ca3af',
        strengthLabel: '',
        matchMsg:  '',
        matchOk:   false,

        checkStrength(val) {
            this.password = val;
            let score = 0;
            if (val.length >= 8)                        score++;
            if (/[a-zA-Z]/.test(val))                  score++;
            if (/[0-9]/.test(val))                      score++;
            if (/[^a-zA-Z0-9]/.test(val) && val.length >= 10) score++;
            this.strength = score;
            const map = {
                0: ['#ef4444', 'Sangat lemah'],
                1: ['#f97316', 'Lemah'],
                2: ['#eab308', 'Sedang'],
                3: ['#22c55e', 'Kuat'],
                4: ['#16a34a', 'Sangat kuat'],
            };
            [this.strengthColor, this.strengthLabel] = map[score];
        },

        checkMatch(val) {
            if (!val) { this.matchMsg = ''; return; }
            if (val === this.password) {
                this.matchOk  = true;
                this.matchMsg = '✓ Password cocok';
            } else {
                this.matchOk  = false;
                this.matchMsg = '✗ Password tidak cocok';
            }
        },
    };
}
</script>
@endpush
