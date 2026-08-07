@extends('layouts.app')

@section('title', 'Jumlah Ikan')

@section('content')
    @php
        $max_ikan_timur = 1500;
        $max_ikan_barat = 2500;
        $percentageTimur = round(($jumlah_ikan_timur / $max_ikan_timur * 100), 2);
        $percentageBarat = round(($jumlah_ikan_barat / $max_ikan_barat * 100), 2);
        $barTone = fn ($p) => $p >= 85 ? 'bg-red-500' : ($p >= 60 ? 'bg-amber-500' : 'bg-emerald-500');
    @endphp
    <div class="animate-fade-in space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Jumlah Ikan</h2>
                <p class="text-sm text-slate-500">Kapasitas ikan per kolam terhadap batas maksimum.</p>
            </div>
            <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <section class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="card p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kolam Timur</p>
                        <p class="mt-1 font-display text-3xl font-bold text-slate-800">{{ $jumlah_ikan_timur }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="fish" class="h-5 w-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <div class="mb-1.5 flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Kapasitas terpakai</span>
                        <span class="font-semibold text-slate-700">{{ $percentageTimur }}%</span>
                    </div>
                    <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full {{ $barTone($percentageTimur) }} transition-all" style="width: {{ min(100, $percentageTimur) }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">dari maksimal {{ $max_ikan_timur }} ekor</p>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Kolam Barat</p>
                        <p class="mt-1 font-display text-3xl font-bold text-slate-800">{{ $jumlah_ikan_barat }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <i data-lucide="fish" class="h-5 w-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <div class="mb-1.5 flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Kapasitas terpakai</span>
                        <span class="font-semibold text-slate-700">{{ $percentageBarat }}%</span>
                    </div>
                    <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full {{ $barTone($percentageBarat) }} transition-all" style="width: {{ min(100, $percentageBarat) }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">dari maksimal {{ $max_ikan_barat }} ekor</p>
                </div>
            </div>
        </section>
    </div>
@endsection
