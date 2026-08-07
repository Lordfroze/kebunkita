@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="card p-8">
        <h2 class="font-display text-2xl font-extrabold text-slate-800">Selamat datang kembali 👋</h2>
        <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola kebun dan bisnis pertanian Anda.</p>

        @if (session('error_message'))
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <span class="mt-0.5 text-red-600"><i data-lucide="circle-alert" class="h-5 w-5"></i></span>
                <p class="text-sm font-medium text-red-800">{{ session('error_message') }}</p>
            </div>
        @endif

        @if (session('success_message'))
            <div class="mt-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <span class="mt-0.5 text-emerald-600"><i data-lucide="circle-check" class="h-5 w-5"></i></span>
                <p class="text-sm font-medium text-emerald-800">{{ session('success_message') }}</p>
            </div>
        @endif

        <form action="{{ url('login') }}" method="POST" class="mt-6 space-y-4" data-auth-form>
            @csrf

            <div>
                <label for="email" class="form-label">Email</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="mail" class="h-4 w-4"></i>
                    </span>
                    <input type="email" id="email" name="email" class="form-input pl-10" placeholder="email@mail.com" required autofocus>
                </div>
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="lock" class="h-4 w-4"></i>
                    </span>
                    <input type="password" id="password" name="password" class="form-input pl-10" placeholder="Password" required>
                </div>
            </div>

            <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-600">
                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-slate-300 accent-emerald-600">
                Ingat perangkat ini
            </label>

            <button type="submit" class="btn-primary w-full !py-3" data-auth-submit>
                <i data-lucide="log-in" class="h-4 w-4"></i>
                <span data-auth-label>Masuk</span>
            </button>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-5 text-center text-sm">
            <p class="text-slate-500">
                Belum punya akun?
                <a href="{{ url('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Daftar sekarang</a>
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
