@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="animate-fade-in space-y-6">
        <section class="flex flex-col gap-1">
            <h2 class="font-display text-2xl font-extrabold text-slate-800">
                Selamat datang kembali, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-sm text-slate-500">
                Pantau kondisi kebun dan bisnis pertanian Anda hari ini.
            </p>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="card group relative overflow-hidden p-5 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">Total Data Keuangan</p>
                        <p class="mt-2 truncate font-display text-2xl font-bold text-slate-800">{{ number_format($stats['keuangan']) }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <i data-lucide="wallet" class="h-5 w-5"></i>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-400">Seluruh transaksi tercatat</p>
            </div>

            <div class="card group relative overflow-hidden p-5 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">Pemasukan Bulan Ini</p>
                        <p class="mt-2 truncate font-display text-2xl font-bold text-slate-800">{{ $stats['pemasukanBulanIniText'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="trending-up" class="h-5 w-5"></i>
                    </span>
                </div>
                <p class="mt-3 flex items-center gap-1 text-xs font-semibold text-emerald-600">
                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i>
                    <span class="text-slate-400 font-normal">Total: Rp {{ number_format($stats['totalPemasukan'], 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="card group relative overflow-hidden p-5 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">Pengeluaran Bulan Ini</p>
                        <p class="mt-2 truncate font-display text-2xl font-bold text-slate-800">{{ $stats['pengeluaranBulanIniText'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <i data-lucide="trending-down" class="h-5 w-5"></i>
                    </span>
                </div>
                <p class="mt-3 flex items-center gap-1 text-xs font-semibold text-amber-600">
                    <i data-lucide="arrow-down-right" class="h-3.5 w-3.5"></i>
                    <span class="text-slate-400 font-normal">Total: Rp {{ number_format($stats['totalPengeluaran'], 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="card group relative overflow-hidden p-5 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">Data Barang</p>
                        <p class="mt-2 truncate font-display text-2xl font-bold text-slate-800">{{ number_format($stats['items']) }}</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i data-lucide="boxes" class="h-5 w-5"></i>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-400">Total pengguna: {{ number_format($stats['users']) }}</p>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <div class="card flex flex-col p-5">
                <div class="mb-4">
                    <h3 class="section-title">Arus Kas Keuangan</h3>
                    <p class="text-xs text-slate-400">Pemasukan vs pengeluaran 7 bulan terakhir</p>
                </div>
                <div class="h-64"><canvas id="chart-keuangan"></canvas></div>
            </div>

            <div class="card flex flex-col p-5">
                <div class="mb-4">
                    <h3 class="section-title">Top Barang berdasarkan Stok</h3>
                    <p class="text-xs text-slate-400">8 barang dengan stok terbesar</p>
                </div>
                <div class="h-64"><canvas id="chart-stok"></canvas></div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <div class="card">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h3 class="section-title">Aktivitas Terbaru</h3>
                        <p class="text-xs text-slate-400">Kegiatan terakhir di sistem Anda</p>
                    </div>
                </div>
                <ul class="divide-y divide-slate-100">
                    @forelse ($recent as $item)
                        @php
                            $map = [
                                'pemasukan' => ['banknote', 'bg-emerald-50 text-emerald-600'],
                                'pengeluaran' => ['trending-down', 'bg-red-50 text-red-600'],
                                'user' => ['user', 'bg-sky-50 text-sky-600'],
                                'stok' => ['boxes', 'bg-lime-50 text-lime-600'],
                            ];
                            $t = $map[$item['tipe']] ?? ['activity', 'bg-slate-100 text-slate-500'];
                        @endphp
                        <li class="flex items-start gap-3 px-5 py-4 transition-colors hover:bg-emerald-50/50">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $t[1] }}">
                                <i data-lucide="{{ $t[0] }}" class="h-[18px] w-[18px]"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-700">{{ $item['judul'] }}</p>
                                <p class="mt-0.5 text-xs text-slate-400">{{ $item['sub'] }}</p>
                            </div>
                            <span class="shrink-0 text-xs font-medium text-slate-400">{{ $item['waktu'] }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center text-sm text-slate-400">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h3 class="section-title">Menu Cepat</h3>
                        <p class="text-xs text-slate-400">Akses cepat ke modul kebun Anda</p>
                    </div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>
                <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2">
                    @php
                        $quick = [
                            ['Perikanan', route('perikanan'), 'fish', 'bg-sky-50 text-sky-600'],
                            ['Perdagangan', route('perdagangan'), 'scale', 'bg-emerald-50 text-emerald-600'],
                            ['Perkebunan', route('perkebunan'), 'sprout', 'bg-lime-50 text-lime-600'],
                            ['Keuangan', route('keuangan'), 'wallet', 'bg-violet-50 text-violet-600'],
                            ['Laporan & Download', route('download'), 'file-down', 'bg-amber-50 text-amber-600'],
                            ['Prakiraan Cuaca', url('weather'), 'cloud-sun', 'bg-sky-50 text-sky-600'],
                        ];
                    @endphp
                    @foreach ($quick as $q)
                        <a href="{{ $q[1] }}"
                           class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3.5 transition-colors hover:border-emerald-300 hover:bg-emerald-50/50">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $q[3] }}">
                                <i data-lucide="{{ $q[2] }}" class="h-5 w-5"></i>
                            </span>
                            <span class="text-sm font-semibold text-slate-700">{{ $q[0] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chart);
        const topItems = @json($topItems);

        const ctx1 = document.getElementById('chart-keuangan');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: chartData.map(d => d.label),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: chartData.map(d => d.pemasukan),
                            backgroundColor: '#059669',
                            borderRadius: 6,
                            maxBarThickness: 22,
                        },
                        {
                            label: 'Pengeluaran',
                            data: chartData.map(d => d.pengeluaran),
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
                        legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8, padding: 16 } },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: {
                                label: (ctx) => ' ' + ctx.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y),
                            },
                        },
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(100,116,139,0.12)' }, ticks: { callback: v => new Intl.NumberFormat('id-ID').format(v) } },
                        x: { grid: { display: false } },
                    },
                },
            });
        }

        const ctx2 = document.getElementById('chart-stok');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: topItems.map(i => i.nama_barang),
                    datasets: [
                        {
                            label: 'Stok',
                            data: topItems.map(i => parseInt(i.stock) || 0),
                            backgroundColor: '#059669',
                            borderRadius: 6,
                            maxBarThickness: 14,
                        },
                    ],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            callbacks: { label: (ctx) => ' Stok: ' + ctx.parsed.x },
                        },
                    },
                    scales: {
                        x: { beginAtZero: true, grid: { color: 'rgba(100,116,139,0.12)' } },
                        y: { grid: { display: false } },
                    },
                },
            });
        }
    });
</script>
@endpush
