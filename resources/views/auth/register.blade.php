@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <div class="card p-8">
        <h2 class="font-display text-2xl font-extrabold text-slate-800">Buat akun baru</h2>
        <p class="mt-1 text-sm text-slate-500">Mulai kelola kebun dan bisnis pertanian Anda.</p>

        @if (session('error_message'))
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <span class="mt-0.5 text-red-600"><i data-lucide="circle-alert" class="h-5 w-5"></i></span>
                <p class="text-sm font-medium text-red-800">{{ session('error_message') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <span class="mt-0.5 text-red-600"><i data-lucide="circle-alert" class="h-5 w-5"></i></span>
                <ul class="list-inside list-disc text-sm text-red-800">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('register') }}" method="POST" class="mt-6 space-y-4" data-auth-form>
            @csrf

            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" placeholder="cth: Budi Santoso" required autofocus>
            </div>

            <div>
                <label for="email" class="form-label">Email</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="mail" class="h-4 w-4"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input pl-10" placeholder="email@mail.com" required>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="lock" class="h-4 w-4"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-input pl-10" placeholder="Min. 8 karakter" required>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full !py-3" data-auth-submit>
                <i data-lucide="user-plus" class="h-4 w-4"></i>
                <span data-auth-label>Daftar</span>
            </button>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-5 text-center text-sm">
            <p class="text-slate-500">
                Sudah punya akun?
                <a href="{{ url('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Masuk sekarang</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[data-auth-form]');
        if (!form) return;
        form.addEventListener('submit', function () {
            const btn = form.querySelector('[data-auth-submit]');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'pointer-events-none');
            btn.querySelector('[data-auth-label]').textContent = 'Mohon ditunggu…';
        });
    });
</script>
@endpush
