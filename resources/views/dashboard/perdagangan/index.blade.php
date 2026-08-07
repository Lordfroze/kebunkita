@extends('layouts.app')

@section('title', 'Perdagangan')

@section('content')
    <div class="animate-fade-in space-y-5">
        <section class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Dashboard Perdagangan</h2>
                <p class="text-sm text-slate-500">Kelola barang dan stok perdagangan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ url('dashboard/perdagangan/kalkulator') }}" class="btn-secondary btn-sm">
                    <i data-lucide="calculator" class="h-4 w-4"></i> Kalkulator
                </a>
                <a href="{{ url('dashboard/perdagangan/create') }}" class="btn-primary btn-sm">
                    <i data-lucide="plus" class="h-4 w-4"></i> Tambah Data
                </a>
            </div>
        </section>

        <x-alert type="success" :message="session('success')" />
        <x-alert type="error" :message="session('error')" />

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <x-stat-card label="Jumlah Items" :value="$items_count" icon="boxes" tone="blue" />
            <x-stat-card label="Jumlah Stock" :value="$stock_count" icon="layers" tone="amber" />
            <x-stat-card label="Penjualan" value="100" icon="banknote" tone="green" footnote="Data contoh" />
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <h3 class="section-title mb-3 px-2 pt-2 sm:px-3">Tabel Perdagangan</h3>
            <table id="tabel-perdagangan" class="dataTable w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
                        <th data-dt-order="disable" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-slate-500">{{ $key + 1 }}</td>
                            <td class="whitespace-nowrap" data-order="{{ $item->updated_at?->timestamp ?? 0 }}">
                                {{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('DD MMM YYYY') }}
                            </td>
                            <td><span class="font-semibold text-slate-700">{{ $item->nama_barang }}</span></td>
                            <td class="whitespace-nowrap text-slate-500">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap font-semibold text-emerald-700">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap">{{ $item->stock }}</td>
                            <td class="text-right">
                                <x-action-menu
                                    :viewUrl="url('dashboard/perdagangan/' . $item->id)"
                                    :editUrl="url('dashboard/perdagangan/' . $item->id . '/edit')"
                                    :deleteUrl="url('/dashboard/perdagangan/' . $item->id)"
                                    confirmText="item {{ $item->nama_barang }}?"
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
        KebunKita.initDataTable('#tabel-perdagangan', {
            order: [[1, 'desc']],
            columnDefs: [{ targets: [0, 6], orderable: false }],
        });
    });
</script>
@endpush
