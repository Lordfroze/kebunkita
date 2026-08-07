@extends('layouts.app')

@section('title', 'Setting Perdagangan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Setting Perdagangan</h2>
                <p class="text-sm text-slate-500">Atur produk dan target penjualan kebun & perikanan.</p>
            </div>
            <a href="{{ url('dashboard/perdagangan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <form action="{{ route('settingbarang') }}" method="POST" class="space-y-5">
            @csrf
            <div class="card p-6">
                <h3 class="section-title mb-4">Setting Perdagangan Perkebunan</h3>
                <div class="space-y-4">
                    <div>
                        <label for="jenis_produk_kebun" class="form-label">Jenis Produk Kebun</label>
                        <input type="text" id="jenis_produk_kebun" name="jenis_produk_kebun" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="harga_jual_kebun" class="form-label">Harga Jual per Kg (Rp)</label>
                            <input type="number" id="harga_jual_kebun" name="harga_jual_kebun" class="form-input" required>
                        </div>
                        <div>
                            <label for="target_produksi_kebun" class="form-label">Target Produksi per Bulan (Kg)</label>
                            <input type="number" id="target_produksi_kebun" name="target_produksi_kebun" class="form-input" required>
                        </div>
                    </div>
                    <div>
                        <label for="metode_penjualan_kebun" class="form-label">Metode Penjualan</label>
                        <select id="metode_penjualan_kebun" name="metode_penjualan_kebun" class="form-select" required>
                            <option value="">Pilih metode penjualan</option>
                            <option value="langsung">Penjualan Langsung</option>
                            <option value="distributor">Melalui Distributor</option>
                            <option value="online">Penjualan Online</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="section-title mb-4">Setting Perdagangan Perikanan</h3>
                <div class="space-y-4">
                    <div>
                        <label for="jenis_ikan" class="form-label">Jenis Ikan</label>
                        <input type="text" id="jenis_ikan" name="jenis_ikan" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="harga_jual_ikan" class="form-label">Harga Jual per Kg (Rp)</label>
                            <input type="number" id="harga_jual_ikan" name="harga_jual_ikan" class="form-input" required>
                        </div>
                        <div>
                            <label for="target_produksi_ikan" class="form-label">Target Produksi per Bulan (Kg)</label>
                            <input type="number" id="target_produksi_ikan" name="target_produksi_ikan" class="form-input" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="metode_penjualan_ikan" class="form-label">Metode Penjualan</label>
                            <select id="metode_penjualan_ikan" name="metode_penjualan_ikan" class="form-select" required>
                                <option value="">Pilih metode penjualan</option>
                                <option value="langsung">Penjualan Langsung</option>
                                <option value="distributor">Melalui Distributor</option>
                                <option value="online">Penjualan Online</option>
                            </select>
                        </div>
                        <div>
                            <label for="jenis_pengolahan" class="form-label">Jenis Pengolahan</label>
                            <select id="jenis_pengolahan" name="jenis_pengolahan" class="form-select" required>
                                <option value="">Pilih jenis pengolahan</option>
                                <option value="segar">Ikan Segar</option>
                                <option value="beku">Ikan Beku</option>
                                <option value="olahan">Ikan Olahan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">
                    <i data-lucide="check" class="h-4 w-4"></i> Simpan Semua Setting
                </button>
            </div>
        </form>
    </div>
@endsection
