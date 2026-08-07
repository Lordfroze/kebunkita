@extends('layouts.app')

@section('title', 'Kalkulator Perdagangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-3xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Kalkulator Perdagangan</h2>
                <p class="text-sm text-slate-500">Hitung perkiraan pendapatan berdasarkan jumlah barang terjual.</p>
            </div>
            <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card overflow-x-auto p-2 sm:p-4">
            <form action="{{ url('dashboard/perdagangan/calculate') }}" method="POST">
                @csrf
                <table class="dataTable w-full">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td><span class="font-semibold text-slate-700">{{ $item->nama_barang }}</span></td>
                                <td class="w-40">
                                    <input type="number"
                                        name="jumlah_terjual[{{ $item->id }}]"
                                        min="0"
                                        value="{{ old('jumlah_terjual.' . $item->id, 0) }}"
                                        class="form-input py-1.5"
                                        placeholder="0">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-slate-400">Belum ada barang untuk dihitung.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex flex-col-reverse gap-2 p-2 sm:flex-row sm:justify-end sm:px-3">
                    <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary">Kembali</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="calculator" class="h-4 w-4"></i> Hitung
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
