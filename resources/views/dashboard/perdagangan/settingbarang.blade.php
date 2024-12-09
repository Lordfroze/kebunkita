@extends('layouts.app')
@section('title')
Setting Kebun, Perikanan, dan Perdagangan
@endsection

@section('content')
<div class="container">
    <form action="{{ route('settingbarang') }}" method="POST">
        <div class="card mb-4">
            <div class="card-header">
                <h2>Setting Perdagangan Perkebunan</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="jenis_produk_kebun" class="form-label">Jenis Produk Kebun</label>
                    <input type="text" class="form-control" id="jenis_produk_kebun" name="jenis_produk_kebun" required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual_kebun" class="form-label">Harga Jual per Kg (Rp)</label>
                    <input type="number" class="form-control" id="harga_jual_kebun" name="harga_jual_kebun" required>
                </div>
                <div class="mb-3">
                    <label for="target_produksi_kebun" class="form-label">Target Produksi per Bulan (Kg)</label>
                    <input type="number" class="form-control" id="target_produksi_kebun" name="target_produksi_kebun" required>
                </div>
                <div class="mb-3">
                    <label for="metode_penjualan_kebun" class="form-label">Metode Penjualan</label>
                    <select class="form-select" id="metode_penjualan_kebun" name="metode_penjualan_kebun" required>
                        <option value="">Pilih metode penjualan</option>
                        <option value="langsung">Penjualan Langsung</option>
                        <option value="distributor">Melalui Distributor</option>
                        <option value="online">Penjualan Online</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2>Setting Perdagangan Perikanan</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="jenis_ikan" class="form-label">Jenis Ikan</label>
                    <input type="text" class="form-control" id="jenis_ikan" name="jenis_ikan" required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual_ikan" class="form-label">Harga Jual per Kg (Rp)</label>
                    <input type="number" class="form-control" id="harga_jual_ikan" name="harga_jual_ikan" required>
                </div>
                <div class="mb-3">
                    <label for="target_produksi_ikan" class="form-label">Target Produksi per Bulan (Kg)</label>
                    <input type="number" class="form-control" id="target_produksi_ikan" name="target_produksi_ikan" required>
                </div>
                <div class="mb-3">
                    <label for="metode_penjualan_ikan" class="form-label">Metode Penjualan</label>
                    <select class="form-select" id="metode_penjualan_ikan" name="metode_penjualan_ikan" required>
                        <option value="">Pilih metode penjualan</option>
                        <option value="langsung">Penjualan Langsung</option>
                        <option value="distributor">Melalui Distributor</option>
                        <option value="online">Penjualan Online</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis_pengolahan" class="form-label">Jenis Pengolahan</label>
                    <select class="form-select" id="jenis_pengolahan" name="jenis_pengolahan" required>
                        <option value="">Pilih jenis pengolahan</option>
                        <option value="segar">Ikan Segar</option>
                        <option value="beku">Ikan Beku</option>
                        <option value="olahan">Ikan Olahan</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Semua Setting</button>
    </form>
</div>
@endsection
