@extends('layouts.app')

@section('title', 'Perkebunan')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Perkebunan</h2>
                <p class="text-sm text-slate-500">Modul pengelolaan kebun dan tanaman.</p>
            </div>
            <a href="{{ route('settingkebun') }}" class="btn-primary btn-sm">
                <i data-lucide="settings" class="h-4 w-4"></i> Setting Kebun
            </a>
        </section>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="card p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="sprout" class="h-5 w-5"></i>
                </span>
                <h3 class="mt-4 font-display text-base font-bold text-slate-800">Tanaman Utama</h3>
                <p class="mt-1 text-sm text-slate-500">Kelola jenis tanaman utama kebun Anda.</p>
            </div>
            <div class="card p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                    <i data-lucide="map" class="h-5 w-5"></i>
                </span>
                <h3 class="mt-4 font-display text-base font-bold text-slate-800">Lahan & Irigasi</h3>
                <p class="mt-1 text-sm text-slate-500">Atur luas lahan dan sistem irigasi.</p>
            </div>
            <div class="card p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="calendar" class="h-5 w-5"></i>
                </span>
                <h3 class="mt-4 font-display text-base font-bold text-slate-800">Musim Tanam</h3>
                <p class="mt-1 text-sm text-slate-500">Jadwalkan musim tanam sesuai kondisi.</p>
            </div>
        </div>

        <div class="card flex flex-col items-center gap-4 px-6 py-12 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                <i data-lucide="sprout" class="h-6 w-6"></i>
            </span>
            <div>
                <h3 class="section-title">Modul Perkebunan sedang dikembangkan</h3>
                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Data tanaman, lahan, dan hasil produksi akan ditampilkan di sini. Sementara itu, gunakan menu
                    Perikanan, Perdagangan, dan Keuangan yang sudah aktif.
                </p>
            </div>
            <a href="{{ route('settingkebun') }}" class="btn-secondary">
                <i data-lucide="settings" class="h-4 w-4"></i> Buka Setting Kebun
            </a>
        </div>
    </div>
@endsection
