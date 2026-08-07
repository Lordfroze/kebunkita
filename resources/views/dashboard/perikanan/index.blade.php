@extends('layouts.app')

@section('title', 'Perikanan')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Dashboard Perikanan</h2>
                <p class="text-sm text-slate-500">Kelola kegiatan perikanan di kolam timur dan barat.</p>
            </div>
            <a href="{{ url('dashboard/perikanan/create') }}" class="btn-primary">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Data
            </a>
        </section>

        <x-alert type="success" :message="session('success')" />

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <a href="{{ url('dashboard/perikanan/kolam_timur') }}" class="block">
                <x-stat-card label="Jumlah Pakan Kolam Timur" :value="$jumlahPakanKolamTimur" icon="fish" tone="blue" footnote="Lihat detail kolam timur →" />
            </a>
            <a href="{{ url('dashboard/perikanan/kolam_barat') }}" class="block">
                <x-stat-card label="Jumlah Pakan Kolam Barat" :value="$jumlahPakanKolamBarat" icon="fish" tone="violet" footnote="Lihat detail kolam barat →" />
            </a>
            <a href="{{ url('dashboard/perikanan/jumlah_ikan') }}" class="block">
                <x-stat-card label="Jumlah Ikan" :value="$jumlahIkan" icon="activity" tone="green" footnote="Lihat kapasitas kolam →" />
            </a>
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2 px-2 pt-2 sm:px-3">
                <h3 class="section-title">Tabel Perikanan</h3>
                <span class="text-xs font-medium text-slate-500">
                    Total biaya (non-panen): <span class="font-semibold text-emerald-700">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</span>
                </span>
            </div>
            <table id="tabel-perikanan" class="dataTable w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Biaya</th>
                        <th data-dt-order="disable" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key => $task)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-slate-500">{{ $key + 1 }}</td>
                            <td class="whitespace-nowrap" data-order="{{ $task->created_at?->timestamp ?? 0 }}">
                                {{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('DD MMM YYYY') }}
                            </td>
                            <td><span class="font-semibold text-slate-700">{{ $task->kegiatan }}</span></td>
                            <td class="text-slate-500">{{ $task->lokasi }}</td>
                            <td class="whitespace-nowrap font-semibold text-slate-700">Rp {{ number_format($task->biaya, 0, ',', '.') }}</td>
                            <td class="text-right">
                                <x-action-menu
                                    :viewUrl="url('dashboard/perikanan/' . $task->id)"
                                    :editUrl="url('dashboard/perikanan/' . $task->id . '/edit')"
                                    :deleteUrl="url('dashboard/perikanan/' . $task->id)"
                                    confirmText="data kegiatan {{ $task->kegiatan }}?"
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
        KebunKita.initDataTable('#tabel-perikanan', {
            order: [[1, 'desc']],
            columnDefs: [{ targets: [0, 5], orderable: false }],
        });
    });
</script>
@endpush
