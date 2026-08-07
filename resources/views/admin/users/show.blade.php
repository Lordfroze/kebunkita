@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Detail User</h2>
                <p class="text-sm text-slate-500">Informasi lengkap akun pengguna.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-secondary btn-sm">
                    <i data-lucide="pencil" class="h-4 w-4"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn-ghost btn-sm">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                </a>
            </div>
        </section>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 border-b border-slate-100 bg-emerald-50/40 px-6 py-5">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-lg font-bold text-white shadow-sm">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </span>
                <div>
                    <p class="font-display text-lg font-bold text-slate-800">{{ $user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 px-6 py-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">ID</dt>
                    <dd class="mt-0.5 font-mono text-sm font-medium text-slate-700">#{{ $user->id }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Role</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">
                        @if ($user->role === 'admin')
                            <span class="badge bg-red-50 text-red-700 ring-1 ring-inset ring-red-200">Admin</span>
                        @else
                            <span class="badge bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200">User</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Bergabung</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $user->created_at?->format('d M Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Terakhir Diperbarui</dt>
                    <dd class="mt-0.5 text-sm font-medium text-slate-700">{{ $user->updated_at?->format('d M Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
