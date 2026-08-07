@extends('layouts.app')

@section('title', 'Tambah Item Perdagangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Tambah Item Perdagangan</h2>
                <p class="text-sm text-slate-500">Catat barang baru beserta harga dan stok.</p>
            </div>
            <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card p-6">
            <form method="POST" action="{{ url('/dashboard/perdagangan') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <div>
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-input" placeholder="cth: royco" required>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" id="harga_beli" name="harga_beli" value="0" class="form-input">
                    </div>
                    <div>
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" id="harga_jual" name="harga_jual" value="0" class="form-input">
                    </div>
                </div>

                <div>
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" value="0" class="form-input">
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" class="h-4 w-4"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
