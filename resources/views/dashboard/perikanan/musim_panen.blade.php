@extends('layouts.app')

@section('title', 'Musim Panen ' . $season)

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Musim Panen {{ $season }}</h2>
                <p class="text-sm text-slate-500">Rekap kegiatan pada musim panen ini.</p>
            </div>
            <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-stat-card label="Total Biaya" :value="'Rp ' . number_format($totalBiaya, 0, ',', '.')" icon="wallet" tone="amber" />
            <x-stat-card label="Jumlah Ikan" :value="number_format($jumlahIkan, 0, ',', '.')" icon="fish" tone="blue" />
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <table id="tabel-musim-panen" class="dataTable w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Biaya</th>
                        <th>Jumlah Ikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-slate-500">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap" data-order="{{ $task->created_at?->timestamp ?? 0 }}">
                                {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}
                            </td>
                            <td><span class="font-semibold text-slate-700">{{ $task->kegiatan }}</span></td>
                            <td class="text-slate-500">{{ $task->lokasi }}</td>
                            <td class="whitespace-nowrap">Rp {{ number_format($task->biaya, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap">{{ number_format($task->jumlah_ikan, 0, ',', '.') }}</td>
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
        KebunKita.initDataTable('#tabel-musim-panen', {
            order: [[1, 'desc']],
            columnDefs: [{ targets: [0], orderable: false }],
        });
    });
</script>
@endpush
