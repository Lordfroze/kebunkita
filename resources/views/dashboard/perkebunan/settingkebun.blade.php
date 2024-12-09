@extends('layouts.app')
@section('title')
Setting Kebun
@endsection

@section('content')
<div class="container">
    <form action="{{ route('settingkebun') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h2>Informasi Kebun</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_kebun" class="form-label">Nama Kebun</label>
                    <input type="text" class="form-control" id="nama_kebun" name="nama_kebun" required>
                </div>
                <div class="mb-3">
                    <label for="luas_kebun" class="form-label">Luas Kebun (m²)</label>
                    <input type="number" class="form-control" id="luas_kebun" name="luas_kebun" required>
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_tanah" class="form-label">Jenis Tanah</label>
                    <select class="form-select" id="jenis_tanah" name="jenis_tanah" required>
                        <option value="">Pilih jenis tanah</option>
                        <option value="lempung">Lempung</option>
                        <option value="pasir">Pasir</option>
                        <option value="liat">Liat</option>
                        <option value="humus">Humus</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2>Pengaturan Tanaman</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="jenis_tanaman" class="form-label">Jenis Tanaman Utama</label>
                    <input type="text" class="form-control" id="jenis_tanaman" name="jenis_tanaman" required>
                </div>
                <div class="mb-3">
                    <label for="musim_tanam" class="form-label">Musim Tanam</label>
                    <select class="form-select" id="musim_tanam" name="musim_tanam" required>
                        <option value="">Pilih musim tanam</option>
                        <option value="hujan">Musim Hujan</option>
                        <option value="kemarau">Musim Kemarau</option>
                        <option value="sepanjang_tahun">Sepanjang Tahun</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sistem_irigasi" class="form-label">Sistem Irigasi</label>
                    <select class="form-select" id="sistem_irigasi" name="sistem_irigasi" required>
                        <option value="">Pilih sistem irigasi</option>
                        <option value="manual">Manual</option>
                        <option value="sprinkler">Sprinkler</option>
                        <option value="drip">Drip Irrigation</option>
                        <option value="tadah_hujan">Tadah Hujan</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Setting Kebun</button>
    </form>
</div>
@endsection

