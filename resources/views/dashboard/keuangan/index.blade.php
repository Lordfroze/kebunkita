@extends('layouts.app')

@section('title', 'Keuangan')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Dashboard Keuangan</h2>
                <p class="text-sm text-slate-500">Pemantauan pemasukan dan pengeluaran.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ url('dashboard/keuangan/export') }}?start_date={{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}&end_date={{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}"
                   class="btn-secondary btn-sm">
                    <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Download Excel
                </a>
                <a href="{{ url('dashboard/keuangan/create') }}" class="btn-primary btn-sm">
                    <i data-lucide="plus" class="h-4 w-4"></i> Tambah Data
                </a>
            </div>
        </section>

        <x-alert type="success" :message="session('success')" />

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <x-stat-card label="Pemasukan" :value="'Rp ' . number_format($totalPemasukan, 0, ',', '.')" icon="trending-up" tone="green" />
            <x-stat-card label="Pengeluaran" :value="'Rp ' . number_format($totalPengeluaran, 0, ',', '.')" icon="trending-down" tone="amber" />
            <x-stat-card label="Total Keseluruhan" :value="'Rp ' . number_format($totalKeseluruhan, 0, ',', '.')" icon="wallet" tone="violet" />
        </section>

        <div class="card p-5">
            <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h3 class="section-title">Grafik Keuangan</h3>
                    <p class="text-xs text-slate-400">Pemasukan vs pengeluaran per bulan</p>
                </div>
                <form method="GET" action="{{ url('/dashboard/keuangan') }}" class="flex flex-wrap items-end gap-2">
                    <div>
                        <label for="start_date" class="form-label">Dari</label>
                        <input type="date" name="start_date" id="start_date" class="form-input" value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="end_date" class="form-label">Sampai</label>
                        <input type="date" name="end_date" id="end_date" class="form-input" value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <button type="submit" class="btn-primary btn-sm">
                        <i data-lucide="search" class="h-4 w-4"></i> Filter
                    </button>
                </form>
            </div>

            <div class="mb-4 flex items-center gap-2">
                <label for="tahunSelect" class="text-sm font-medium text-slate-500">Tahun:</label>
                <select id="tahunSelect" class="form-input w-32 py-1.5"></select>
            </div>
            <div class="h-64"><canvas id="barChart"></canvas></div>
        </div>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <h3 class="section-title mb-3 px-2 pt-2 sm:px-3">Tabel Keuangan</h3>
            <table id="tabel-keuangan" class="dataTable w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                        <th>Selisih</th>
                        <th data-dt-order="disable" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key => $task)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-slate-500">{{ $key + 1 }}</td>
                            <td class="whitespace-nowrap" data-order="{{ $task->created_at?->timestamp ?? 0 }}">
                                {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}
                            </td>
                            <td class="whitespace-nowrap font-semibold text-emerald-700">+ Rp {{ number_format($task->pemasukan, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap font-semibold text-red-600">− Rp {{ number_format($task->pengeluaran, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap text-slate-500">Rp {{ number_format($task->pemasukan - $task->pengeluaran, 0, ',', '.') }}</td>
                            <td class="text-right">
                                <x-action-menu
                                    :viewUrl="url('dashboard/keuangan/' . $task->id)"
                                    :editUrl="url('dashboard/keuangan/' . $task->id . '/edit')"
                                    :deleteUrl="url('dashboard/keuangan/' . $task->id)"
                                    confirmText="data keuangan tanggal {{ \Carbon\Carbon::parse($task->created_at)->format('d M Y') }}?"
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
        KebunKita.initDataTable('#tabel-keuangan', {
            order: [[1, 'desc']],
            columnDefs: [{ targets: [0, 5], orderable: false }],
        });

        let myChart = null;

        function loadChart(tahun) {
            const url = tahun
                ? `{{ url('/dashboard/keuangan/chart-data') }}?tahun=${tahun}`
                : `{{ url('/dashboard/keuangan/chart-data') }}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('tahunSelect');
                    select.innerHTML = '';
                    data.tahunTersedia.forEach(t => {
                        const opt = document.createElement('option');
                        opt.value = t;
                        opt.textContent = t;
                        if (t === data.tahun) opt.selected = true;
                        select.appendChild(opt);
                    });

                    const ctx = document.getElementById('barChart').getContext('2d');
                    if (myChart) myChart.destroy();

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Pemasukan',
                                    data: data.pemasukan,
                                    backgroundColor: '#059669',
                                    borderRadius: 6,
                                    maxBarThickness: 22,
                                },
                                {
                                    label: 'Pengeluaran',
                                    data: data.pengeluaran,
                                    backgroundColor: '#f59e0b',
                                    borderRadius: 6,
                                    maxBarThickness: 22,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { intersect: false, mode: 'index' },
                            plugins: {
                                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8 } },
                                title: {
                                    display: true,
                                    text: 'Grafik Keuangan Tahun ' + data.tahun,
                                    font: { family: "'Plus Jakarta Sans', sans-serif", weight: 'bold', size: 14 },
                                    color: '#0f172a',
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(100,116,139,0.12)' },
                                    ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID') },
                                },
                            },
                        },
                    });
                });
        }

        loadChart();

        const tahunSelect = document.getElementById('tahunSelect');
        if (tahunSelect) {
            tahunSelect.addEventListener('change', function () {
                loadChart(this.value);
            });
        }
    });
</script>
@endpush
