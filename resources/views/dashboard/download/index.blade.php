@extends('layouts.app')

@section('title', 'Download Data')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Download Data</h2>
                <p class="text-sm text-slate-500">Unduh data kegiatan dalam format Excel.</p>
            </div>
        </section>

        <div class="card">
            <div class="border-b border-slate-100 px-5 py-4">
                <h3 class="section-title">Data Perikanan</h3>
                <p class="text-xs text-slate-400">Ekspor data per lokasi kolam</p>
            </div>
            <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2">
                <a href="{{ url('download-excel?lokasi_like=Kolam%20Timur') }}"
                   class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition-colors hover:border-emerald-300 hover:bg-emerald-50/50">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i data-lucide="fish" class="h-5 w-5"></i>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-700">Data Kolam Timur</span>
                        <span class="block text-xs text-slate-400">Unduh data kegiatan kolam timur</span>
                    </span>
                    <i data-lucide="download" class="ml-auto h-4 w-4 text-slate-400"></i>
                </a>
                <a href="{{ url('download-excel?lokasi_like=Kolam%20Barat') }}"
                   class="flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition-colors hover:border-emerald-300 hover:bg-emerald-50/50">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <i data-lucide="fish" class="h-5 w-5"></i>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-700">Data Kolam Barat</span>
                        <span class="block text-xs text-slate-400">Unduh data kegiatan kolam barat</span>
                    </span>
                    <i data-lucide="download" class="ml-auto h-4 w-4 text-slate-400"></i>
                </a>
            </div>
        </div>

        <div class="card flex items-center gap-4 px-5 py-4">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <i data-lucide="file-spreadsheet" class="h-5 w-5"></i>
            </span>
            <p class="text-sm text-slate-500">
                File yang diunduh berupa <span class="font-semibold text-slate-700">Excel (.xlsx)</span> berisi data kegiatan perikanan sesuai lokasi yang dipilih.
            </p>
        </div>
    </div>
@endsection
