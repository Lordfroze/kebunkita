@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Manajemen User</h2>
                <p class="text-sm text-slate-500">Kelola akun pengguna sistem KebunKita.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah User
            </a>
        </section>

        <x-alert type="success" :message="session('success')" />
        <x-alert type="error" :message="session('error')" />

        <div class="card overflow-x-auto p-2 sm:p-4">
            <table id="tabel-users" class="dataTable w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Bergabung</th>
                        <th data-dt-order="disable" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-slate-500">{{ $user->id }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-800">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-slate-500">{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge bg-red-50 text-red-700 ring-1 ring-inset ring-red-200">Admin</span>
                                @else
                                    <span class="badge bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200">User</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap" data-order="{{ $user->created_at?->timestamp ?? 0 }}">
                                {{ $user->created_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="text-right">
                                <x-action-menu
                                    :viewUrl="route('admin.users.show', $user->id)"
                                    :editUrl="route('admin.users.edit', $user->id)"
                                    :deleteUrl="route('admin.users.destroy', $user->id)"
                                    confirmText="user {{ $user->name }}"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        KebunKita.initDataTable('#tabel-users', {
            order: [[4, 'desc']],
            columnDefs: [{ targets: [0, 5], orderable: false }],
        });
    });
</script>
@endpush
