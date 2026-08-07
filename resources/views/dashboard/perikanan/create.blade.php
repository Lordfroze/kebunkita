@extends('layouts.app')

@section('title', 'Tambah Data Perikanan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Tambah Data Perikanan</h2>
                <p class="text-sm text-slate-500">Catat kegiatan baru untuk kolam Anda.</p>
            </div>
            <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card p-6">
            <form method="POST" action="{{ url('/dashboard/perikanan') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <div>
                    <span class="form-label">Kegiatan</span>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="BeliPakan" value="Beli Pakan" class="accent-emerald-600" required>
                            Beli Pakan
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="PembersihkanKolam" value="Pembersihkan Kolam" class="accent-emerald-600">
                            Pembersihkan Kolam
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="kurangi_ikan" value="Kurangi ikan" class="accent-emerald-600">
                            Kurangi Ikan
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="tambah_ikan" value="Tambah ikan" class="accent-emerald-600">
                            Tambah Ikan
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="PanenIkan" value="Panen Ikan" class="accent-emerald-600">
                            Panen Ikan
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="kegiatan" id="KegiatanLain" value="other" class="accent-emerald-600">
                            Lainnya
                        </label>
                    </div>
                    <div id="kurangi_ikanInput" class="hidden mt-2">
                        <input type="number" class="form-input" name="kurangi_ikanInput" placeholder="Jumlah ikan yang dikurangi">
                    </div>
                    <div id="tambah_ikanInput" class="hidden mt-2">
                        <input type="number" class="form-input" name="tambah_ikanInput" placeholder="Jumlah ikan yang ditambah">
                    </div>
                    <div id="otherKegiatanInput" class="hidden mt-2">
                        <input type="text" class="form-input" name="kegiatan_other" placeholder="Sebutkan kegiatan lainnya">
                    </div>
                </div>

                <div>
                    <span class="form-label">Lokasi</span>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="lokasi" id="KolamTimur" value="Kolam Timur" class="accent-emerald-600" required>
                            Kolam Timur
                        </label>
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-medium text-slate-700 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="lokasi" id="KolamBarat" value="Kolam Barat" class="accent-emerald-600">
                            Kolam Barat
                        </label>
                    </div>
                </div>

                <div>
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" id="biaya" name="biaya" value="0" class="form-input">
                </div>

                <div>
                    <label for="musim_panen" class="form-label">Musim Panen</label>
                    <input type="number" id="musim_panen" name="musim_panen" value="1" class="form-input" required>
                    <p class="mt-1 text-xs text-slate-400">Terisi otomatis berdasarkan musim terakhir per lokasi.</p>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" class="h-4 w-4"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kegiatanLain = document.getElementById('KegiatanLain');
        const otherInput = document.getElementById('otherKegiatanInput');
        const kurangiIkan = document.getElementById('kurangi_ikan');
        const kurangiInput = document.getElementById('kurangi_ikanInput');
        const tambahIkan = document.getElementById('tambah_ikan');
        const tambahInput = document.getElementById('tambah_ikanInput');

        function toggleInputs() {
            otherInput.classList.toggle('hidden', !(kegiatanLain && kegiatanLain.checked));
            kurangiInput.classList.toggle('hidden', !(kurangiIkan && kurangiIkan.checked));
            tambahInput.classList.toggle('hidden', !(tambahIkan && tambahIkan.checked));
        }

        document.querySelectorAll('input[name="kegiatan"]').forEach(function (radio) {
            radio.addEventListener('change', toggleInputs);
        });

        const musimPanenInput = document.getElementById('musim_panen');
        const latestMusimPanen = @json($latestMusimPanen);

        document.querySelectorAll('input[name="lokasi"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const selected = this.value;
                if (selected in latestMusimPanen) {
                    musimPanenInput.value = parseInt(latestMusimPanen[selected]) + 1;
                } else {
                    musimPanenInput.value = 1;
                }
            });
        });

        toggleInputs();
    });
</script>
@endpush
