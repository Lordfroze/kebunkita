@extends('layouts.app')

@section('title', 'Hasil Kalkulator Perdagangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-3xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Hasil Kalkulator Perdagangan</h2>
                <p class="text-sm text-slate-500">Tanggal: {{ $tanggal }}</p>
            </div>
            <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <table class="dataTable w-full">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah Terjual</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-semibold text-slate-700">{{ $result['name'] }}</span></td>
                            <td>{{ $result['quantity'] }}</td>
                            <td class="whitespace-nowrap">Rp {{ number_format($result['price'], 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap font-semibold text-emerald-700">Rp {{ number_format($result['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="!bg-emerald-50 !text-slate-800" colspan="3">Total Keseluruhan</th>
                        <th class="!bg-emerald-50 !text-emerald-700">Rp {{ number_format(array_sum(array_column($results, 'total')), 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ url('dashboard/perdagangan/kalkulator') }}" class="btn-secondary">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Kalkulator
            </a>
            <a href="{{ route('kalkulator.download', ['results' => json_encode($results)]) }}" class="btn-danger">
                <i data-lucide="file-down" class="h-4 w-4"></i> Download PDF
            </a>
        </div>
    </div>
@endsection
