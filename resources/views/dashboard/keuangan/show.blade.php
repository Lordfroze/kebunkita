@extends('layouts.app')

@section('title', 'Detail Keuangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Detail Keuangan</h2>
                <p class="text-sm text-slate-500">Data keuangan #{{ $task->id }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('dashboard/keuangan/' . $task->id . '/edit') }}" class="btn-secondary btn-sm">
                    <i data-lucide="pencil" class="h-4 w-4"></i> Edit
                </a>
                <a href="{{ url('dashboard/keuangan') }}" class="btn-ghost btn-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                </a>
            </div>
        </section>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 border-b border-slate-100 bg-emerald-50/40 px-6 py-5">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                    <i data-lucide="wallet" class="h-7 w-7"></i>
                </span>
                <div>
                    <p class="font-display text-lg font-bold text-slate-800">Transaksi Keuangan</p>
                    <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</p>
                </div>
            </div>
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 px-6 py-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Pemasukan</dt>
                    <dd class="mt-0.5 text-sm font-bold text-emerald-700">+ Rp {{ number_format($task->pemasukan, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Pengeluaran</dt>
                    <dd class="mt-0.5 text-sm font-bold text-red-600">− Rp {{ number_format($task->pengeluaran, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Selisih</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-slate-700">Rp {{ number_format($task->pemasukan - $task->pengeluaran, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">ID</dt>
                    <dd class="mt-0.5 font-mono text-sm font-medium text-slate-700">#{{ $task->id }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
