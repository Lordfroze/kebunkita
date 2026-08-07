@extends('layouts.app')

@section('title', 'Detail Kolam Barat')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Detail Kolam Barat</h2>
                <p class="text-sm text-slate-500">Pemantauan biaya dan kegiatan kolam barat.</p>
            </div>
            <a href="{{ url('dashboard/perikanan/create') }}" class="btn-primary">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Data
            </a>
        </section>

        <x-alert type="success" :message="session('success')" />

        <section class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="card flex flex-col p-5">
                <div class="mb-4">
                    <h3 class="section-title">Grafik Bulanan Kolam Barat</h3>
                    <p class="text-xs text-slate-400">Total biaya per bulan</p>
                </div>
                <div class="h-64"><canvas id="kolamBaratChart"></canvas></div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-stat-card label="Jumlah Pakan Kolam Barat" :value="$jumlahPakanKolamBarat" icon="cookie" tone="violet" />
                <x-stat-card label="Jumlah Ikan Kolam Barat" :value="$jumlah_ikan_barat" icon="fish" tone="green" />
                <x-stat-card label="Jumlah Biaya" :value="'Rp ' . number_format($totalBiayaKolamBarat, 0, ',', '.')" icon="wallet" tone="amber" />
                <x-stat-card label="Biaya Panen" :value="'Rp ' . number_format($totalBiayaPanenKolamBarat, 0, ',', '.')" icon="banknote" tone="violet" />
            </div>
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2 px-2 pt-2 sm:px-3">
                <h3 class="section-title">Tabel Perikanan Kolam Barat</h3>
                <span class="text-xs font-medium text-slate-500">
                    Selisih biaya: <span class="font-semibold text-emerald-700">Rp {{ number_format($selisihBiayaPanen, 0, ',', '.') }}</span>
                </span>
            </div>
            <table id="tabel-kolam-barat" class="dataTable w-full">
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
            <div class="px-2 pb-2 sm:px-3">
                <form action="{{ route('perikanan.kolam_barat.deleteAll') }}" method="POST" data-confirm-delete="semua data perikanan Kolam Barat?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger btn-sm">
                        <i data-lucide="trash-2" class="h-4 w-4"></i> Hapus Seluruh Data Kolam Barat
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        KebunKita.initDataTable('#tabel-kolam-barat', {
            order: [[1, 'desc']],
            columnDefs: [{ targets: [0, 5], orderable: false }],
        });

        const ctx = document.getElementById('kolamBaratChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Total Biaya',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(139, 92, 246, 0.5)',
                        borderColor: '#8b5cf6',
                        borderWidth: 1,
                        borderRadius: 6,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(100,116,139,0.12)' },
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: {
                                label: (c) => ' Biaya: Rp ' + new Intl.NumberFormat('id-ID').format(c.parsed.x),
                            },
                        },
                    },
                },
            });
        }
    });
</script>
@endpush
