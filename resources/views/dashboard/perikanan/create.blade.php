@extends('layouts.app')
@section('title')
Tambah Data
@endsection

@section('content')
<div class="content">
    <form method="POST" action="{{url ('/dashboard/perikanan')}}">
        @csrf
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="BeliPakan" value="Beli Pakan" required>
                <label class="form-check-label" for="BeliPakan">
                    Beli Pakan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="PembersihkanKolam" value="Pembersihkan Kolam">
                <label class="form-check-label" for="PembersihkanKolam">
                    Pembersihkan Kolam
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="kurangi_ikan" value="Kurangi ikan">
                <label class="form-check-label" for="kurangi_ikan">
                    Kurangi Ikan
                </label>
            </div>
            <div id="kurangi_ikanInput" style="display: none;">
                <input type="number" class="form-control mt-2" name="kurangi_ikanInput" placeholder="Jumlah ikan yang dikurangi">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="tambah_ikan" value="Tambah ikan">
                <label class="form-check-label" for="tambah_ikan">
                    Tambah Ikan
                </label>
            </div>
            <div id="tambah_ikanInput" style="display: none;">
                <input type="number" class="form-control mt-2" name="tambah_ikanInput" placeholder="Jumlah ikan yang ditambah">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="PanenIkan" value="Panen Ikan">
                <label class="form-check-label" for="PanenIkan">
                    Panen Ikan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="KegiatanLain" value="other">
                <label class="form-check-label" for="KegiatanLain">
                    Lainnya
                </label>
            </div>
            <div id="otherKegiatanInput" style="display: none;">
                <input type="text" class="form-control mt-2" name="kegiatan_other" placeholder="Sebutkan kegiatan lainnya">
            </div>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="lokasi" id="KolamTimur" value="Kolam Timur" required>
                <label class="form-check-label" for="KolamTimur">
                    Kolam Timur
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="lokasi" id="KolamBarat" value="Kolam Barat">
                <label class="form-check-label" for="KolamBarat">
                    Kolam Barat
                </label>
            </div>
            <!-- <textarea class="form-control" id="lokasi" rows="3" name="lokasi"></textarea> -->
        </div>
        <div class="mb-3">
            <label for="biaya" class="form-label">Biaya</label>
            <input type="number" class="form-control" id="biaya" name="biaya" value="0">
        </div>

        <div class="mb-3">
            <label for="musim_panen" class="form-label">Musim</label>

            <input type="number" class="form-control" id="musim_panen" name="musim_panen" value="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- munculkan tombol lain -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kegiatanLain = document.getElementById('KegiatanLain');
        const otherInput = document.getElementById('otherKegiatanInput');
        const kurangi_ikan = document.getElementById('kurangi_ikan');
        const kurangi_ikanInput = document.getElementById('kurangi_ikanInput');
        const tambah_ikan = document.getElementById('tambah_ikan');
        const tambah_ikanInput = document.getElementById('tambah_ikanInput');

        function toggleInputs() {
            otherInput.style.display = kegiatanLain.checked ? 'block' : 'none';
            kurangi_ikanInput.style.display = kurangi_ikan.checked ? 'block' : 'none';
            tambah_ikanInput.style.display = tambah_ikan.checked ? 'block' : 'none';
        }

        document.querySelectorAll('input[name="kegiatan"]').forEach(function(radio) {
            radio.addEventListener('change', toggleInputs);
        });

        toggleInputs(); // Initial check
    });
</script>

<!-- mendapatkan latest musim berdasarkan lokasi -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lokasiSelect = document.getElementById('lokasi');
        const musimPanenInput = document.getElementById('musim_panen');
        const latestMusimPanen = @json($latestMusimPanen);

        lokasiSelect.addEventListener('change', function() {
            const selectedLokasi = this.value;
            if (selectedLokasi in latestMusimPanen) {
                musimPanenInput.value = latestMusimPanen[selectedLokasi] + 1;
            } else {
                musimPanenInput.value = 1;
            }
        });
    });
</script>
@endsection