@extends('layouts.app')

@section('title', 'Prakiraan Cuaca')

@php
    $weatherIcon = function ($desc) {
        $d = strtolower((string) $desc);
        return str_contains($d, 'hujan lebat') || str_contains($d, 'badai') ? 'cloud-lightning'
            : (str_contains($d, 'hujan') ? 'cloud-rain'
            : (str_contains($d, 'kabut') ? 'cloud-fog'
            : (str_contains($d, 'salju') ? 'cloud-snow'
            : (str_contains($d, 'berawan') ? 'cloud-sun'
            : (str_contains($d, 'cerah') ? 'sun' : 'cloud')))));
    };
@endphp

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Prakiraan Cuaca</h2>
                <p class="text-sm text-slate-500">Sumber data: BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)</p>
            </div>
            <a href="{{ url('weather') }}" class="btn-secondary btn-sm">
                <i data-lucide="rotate-cw" class="h-4 w-4"></i> Perbarui
            </a>
        </section>

        @if (isset($error))
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <span class="mt-0.5 text-red-600"><i data-lucide="circle-alert" class="h-5 w-5"></i></span>
                <div>
                    <p class="text-sm font-semibold text-red-800">Gagal memuat data cuaca</p>
                    <p class="text-sm text-red-700">{{ $error }}</p>
                </div>
            </div>
        @else
            <div class="card overflow-hidden">
                <div class="flex items-center gap-4 border-b border-slate-100 bg-emerald-50/40 px-6 py-5">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                        <i data-lucide="map-pin" class="h-7 w-7"></i>
                    </span>
                    <div>
                        <p class="font-display text-lg font-bold text-slate-800">{{ $weatherData['lokasi']['desa'] ?? '-' }}</p>
                        <p class="text-sm text-slate-500">
                            {{ $weatherData['lokasi']['kecamatan'] ?? '-' }} · {{ $weatherData['lokasi']['kotkab'] ?? '-' }} · {{ $weatherData['lokasi']['provinsi'] ?? '-' }}
                        </p>
                    </div>
                    <span class="ml-auto hidden text-xs font-medium text-slate-400 sm:block">
                        Diperbarui: {{ now()->format('H:i') }}
                    </span>
                </div>
                <dl class="grid grid-cols-2 gap-x-6 gap-y-3 px-6 py-5 sm:grid-cols-4">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Provinsi</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-slate-700">{{ $weatherData['lokasi']['provinsi'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Kota / Kabupaten</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-slate-700">{{ $weatherData['lokasi']['kotkab'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Kecamatan</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-slate-700">{{ $weatherData['lokasi']['kecamatan'] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Desa</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-slate-700">{{ $weatherData['lokasi']['desa'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach (($weatherData['data'][0]['cuaca'][0] ?? []) as $w)
                    @php
                        $dt = \Carbon\Carbon::parse($w['local_datetime'] ?? $w['datetime'] ?? now());
                        $ic = $weatherIcon($w['weather_desc'] ?? '');
                        $hu = $w['hu'] ?? null;
                        $ws = $w['ws'] ?? null;
                    @endphp
                    <div class="card p-5 transition-shadow hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $dt->locale('id')->isoFormat('dddd') }}</p>
                                <p class="text-xs text-slate-400">{{ $dt->format('d M Y H:i') }}</p>
                            </div>
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                <i data-lucide="{{ $ic }}" class="h-5 w-5"></i>
                            </span>
                        </div>
                        <div class="mt-4 flex items-end gap-1">
                            <span class="font-display text-4xl font-extrabold text-slate-800">{{ $w['t'] ?? '-' }}°</span>
                            <span class="mb-1 text-sm text-slate-400">C</span>
                        </div>
                        <p class="mt-1 text-sm font-medium text-emerald-700">{{ $w['weather_desc'] ?? '-' }}</p>
                        <div class="mt-4 grid grid-cols-2 gap-2 text-xs text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="droplets" class="h-3.5 w-3.5 text-sky-500"></i>
                                Kelembapan {{ $hu !== null ? $hu . '%' : '-' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="wind" class="h-3.5 w-3.5 text-slate-400"></i>
                                Angin {{ $ws !== null ? $ws . ' km/h' : '-' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </section>

            @if (empty($weatherData['data'][0]['cuaca'][0] ?? []))
                <div class="card flex flex-col items-center gap-4 px-6 py-12 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                        <i data-lucide="cloud-sun" class="h-6 w-6"></i>
                    </span>
                    <p class="text-sm text-slate-500">Belum ada data prakiraan cuaca untuk lokasi ini.</p>
                </div>
            @endif
        @endif
    </div>
@endsection
