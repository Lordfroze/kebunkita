@extends('layouts.app')

@section('title', 'Setting Kebun')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Setting Kebun</h2>
                <p class="text-sm text-slate-500">Atur informasi kebun dan pengaturan tanaman.</p>
            </div>
            <a href="{{ url('dashboard/perkebunan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <form action="{{ route('settingkebun') }}" method="POST" class="space-y-5">
            @csrf
            <div class="card p-6">
                <h3 class="section-title mb-4">Informasi Kebun</h3>
                <div class="space-y-4">
                    <div>
                        <label for="nama_kebun" class="form-label">Nama Kebun</label>
                        <input type="text" id="nama_kebun" name="nama_kebun" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="luas_kebun" class="form-label">Luas Kebun (m²)</label>
                            <input type="number" id="luas_kebun" name="luas_kebun" class="form-input" required>
                        </div>
                        <div>
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" id="lokasi" name="lokasi" class="form-input" required>
                        </div>
                    </div>
                    <div>
                        <label for="jenis_tanah" class="form-label">Jenis Tanah</label>
                        <select id="jenis_tanah" name="jenis_tanah" class="form-select" required>
                            <option value="">Pilih jenis tanah</option>
                            <option value="lempung">Lempung</option>
                            <option value="pasir">Pasir</option>
                            <option value="liat">Liat</option>
                            <option value="humus">Humus</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="section-title mb-4">Pengaturan Tanaman</h3>
                <div class="space-y-4">
                    <div>
                        <label for="jenis_tanaman" class="form-label">Jenis Tanaman Utama</label>
                        <input type="text" id="jenis_tanaman" name="jenis_tanaman" class="form-input" required>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="musim_tanam" class="form-label">Musim Tanam</label>
                            <select id="musim_tanam" name="musim_tanam" class="form-select" required>
                                <option value="">Pilih musim tanam</option>
                                <option value="hujan">Musim Hujan</option>
                                <option value="kemarau">Musim Kemarau</option>
                                <option value="sepanjang_tahun">Sepanjang Tahun</option>
                            </select>
                        </div>
                        <div>
                            <label for="sistem_irigasi" class="form-label">Sistem Irigasi</label>
                            <select id="sistem_irigasi" name="sistem_irigasi" class="form-select" required>
                                <option value="">Pilih sistem irigasi</option>
                                <option value="manual">Manual</option>
                                <option value="sprinkler">Sprinkler</option>
                                <option value="drip">Drip Irrigation</option>
                                <option value="tadah_hujan">Tadah Hujan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">
                    <i data-lucide="check" class="h-4 w-4"></i> Simpan Setting Kebun
                </button>
            </div>
        </form>
    </div>
@endsection
