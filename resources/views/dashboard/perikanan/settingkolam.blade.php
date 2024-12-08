@extends('layouts.app')
@section('title')
Setting Kolam
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Setting Kolam dan Pakan Ikan</h1>

    <form action="{{ route('settingkolam') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h2>Tambah Data Kolam</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_kolam" class="form-label">Nama Kolam</label>
                    <input type="text" class="form-control" id="nama_kolam" name="nama_kolam" required>
                </div>
                <div class="mb-3">
                    <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                    <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" required>
                </div>
                <div class="mb-3">
                    <label for="kedalaman_kolam" class="form-label">Kedalaman Kolam (m)</label>
                    <input type="number" step="0.1" class="form-control" id="kedalaman_kolam" name="kedalaman_kolam" required>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2>Setting Pakan Ikan</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="jenis_pakan" class="form-label">Jenis Pakan</label>
                    <input type="text" class="form-control" id="jenis_pakan" name="jenis_pakan" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah_pakan" class="form-label">Jumlah Pakan per Hari (kg)</label>
                    <input type="number" step="0.1" class="form-control" id="jumlah_pakan" name="jumlah_pakan" required>
                </div>
                <div class="mb-3">
                    <label for="frekuensi_pakan" class="form-label">Frekuensi Pemberian Pakan per Hari</label>
                    <input type="number" class="form-control" id="frekuensi_pakan" name="frekuensi_pakan" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
