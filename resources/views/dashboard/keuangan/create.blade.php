@extends('layouts.app')
@section('title')
Tambah Data Keuangan
@endsection

@section('content')
<div class="content">
    <form method="POST" action="{{url ('/dashboard/keuangan')}}">
        @csrf
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>

        <div class="mb-3">
            <label for="pemasukan" class="form-label">Pemasukan</label>
            <input type="number" class="form-control" id="pemasukan" name="pemasukan" required>
        </div>

        <div class="mb-3">
            <label for="pengeluaran" class="form-label">Pengeluaran</label>
            <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection