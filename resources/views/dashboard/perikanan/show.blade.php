@extends('layouts.app')

@section('title', 'Detail ' . $task->kegiatan)

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Detail Kegiatan</h2>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('dashboard/perikanan/' . $task->id . '/edit') }}" class="btn-secondary btn-sm">
                    <i data-lucide="pencil" class="h-4 w-4"></i> Edit
                </a>
                <a href="{{ url('dashboard/perikanan') }}" class="btn-ghost btn-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                </a>
            </div>
        </section>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 border-b border-slate-100 bg-emerald-50/40 px-6 py-5">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                    <i data-lucide="fish" class="h-7 w-7"></i>
                </span>
                <div>
                    <p class="font-display text-lg font-bold text-slate-800">{{ $task->kegiatan }}</p>
                    <p class="text-sm text-slate-500">{{ $task->lokasi }}</p>
                </div>
            </div>
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 px-6 py-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">ID</dt>
                    <dd class="mt-0.5 font-mono text-sm font-medium text-slate-700">#{{ $task->id }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Lokasi</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $task->lokasi }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Biaya</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">Rp {{ number_format($task->biaya, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Tanggal</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('DD MMMM YYYY') }}</dd>
                </div>
            </dl>
        </div>

        <div class="card">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h3 class="section-title">Komentar</h3>
                    <p class="text-xs text-slate-400">{{ $total_comments }} komentar</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500">
                    <i data-lucide="messages-square" class="h-4 w-4"></i>
                </span>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($comments as $comment)
                    <li class="px-5 py-4">
                        <p class="text-sm text-slate-700">{{ $comment->comment }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ optional($comment->created_at)->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-sm text-slate-400">Belum ada komentar.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
