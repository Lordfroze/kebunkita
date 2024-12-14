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
            <input type="date" class="form-control" id="tanggal" name="tanggal">
        </div>

        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="BeliPakan" value="Beli Pakan">
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
                <input class="form-check-input" type="radio" name="kegiatan" id="PanenIkan" value="Panen Ikan">
                <label class="form-check-label" for="PanenIkan">
                    Panen Ikan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="kegiatan" id="PemeriksaanKesehatan" value="Pemeriksaan Kesehatan">
                <label class="form-check-label" for="PemeriksaanKesehatan">
                    Pemeriksaan Kesehatan
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
            <textarea class="form-control" id="lokasi" rows="3" name="lokasi"></textarea>
        </div>
        <div class="mb-3">
            <label for="biaya" class="form-label">Biaya</label>
            <input type="number" class="form-control" id="biaya" name="biaya">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kegiatanLain = document.getElementById('KegiatanLain');
    const otherInput = document.getElementById('otherKegiatanInput');

    function toggleOtherInput() {
        otherInput.style.display = kegiatanLain.checked ? 'block' : 'none';
    }

    document.querySelectorAll('input[name="kegiatan"]').forEach(function(radio) {
        radio.addEventListener('change', toggleOtherInput);
    });

    toggleOtherInput(); // Initial check
});
</script>
@endsection
