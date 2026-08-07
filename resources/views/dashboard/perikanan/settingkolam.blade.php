@extends('layouts.app')

@section('title', 'Setting Kolam')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Setting Kolam</h2>
                <p class="text-sm text-slate-500">Atur informasi kolam dan pakan ikan.</p>
            </div>
            <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <form action="{{ route('settingkolam') }}" method="POST" class="space-y-5">
            @csrf
            <div class="card p-6">
                <h3 class="section-title mb-4">Tambah Data Kolam</h3>
                <div class="space-y-4">
                    <div>
                        <label for="nama_kolam" class="form-label">Nama Kolam</label>
                        <input type="text" id="nama_kolam" name="nama_kolam" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                            <input type="number" id="luas_kolam" name="luas_kolam" class="form-input" required>
                        </div>
                        <div>
                            <label for="kedalaman_kolam" class="form-label">Kedalaman Kolam (m)</label>
                            <input type="number" step="0.1" id="kedalaman_kolam" name="kedalaman_kolam" class="form-input" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="section-title mb-4">Setting Pakan Ikan</h3>
                <div class="space-y-4">
                    <div>
                        <label for="jenis_pakan" class="form-label">Jenis Pakan</label>
                        <input type="text" id="jenis_pakan" name="jenis_pakan" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="jumlah_pakan" class="form-label">Jumlah Pakan per Hari (kg)</label>
                            <input type="number" step="0.1" id="jumlah_pakan" name="jumlah_pakan" class="form-input" required>
                        </div>
                        <div>
                            <label for="frekuensi_pakan" class="form-label">Frekuensi Pemberian Pakan per Hari</label>
                            <input type="number" id="frekuensi_pakan" name="frekuensi_pakan" class="form-input" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">
                    <i data-lucide="check" class="h-4 w-4"></i> Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
