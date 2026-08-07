@extends('layouts.app')

@section('title', 'Tambah Data Keuangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Tambah Data Keuangan</h2>
                <p class="text-sm text-slate-500">Catat pemasukan atau pengeluaran baru.</p>
            </div>
            <a href="{{ url('dashboard/keuangan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card p-6">
            <form method="POST" action="{{ url('/dashboard/keuangan') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="pemasukan" class="form-label">Pemasukan</label>
                        <input type="number" id="pemasukan" name="pemasukan" value="0" class="form-input" required>
                    </div>
                    <div>
                        <label for="pengeluaran" class="form-label">Pengeluaran</label>
                        <input type="number" id="pengeluaran" name="pengeluaran" value="0" class="form-input">
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ url('dashboard/keuangan') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" class="h-4 w-4"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
