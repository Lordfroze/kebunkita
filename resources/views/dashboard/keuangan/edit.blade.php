@extends('layouts.app')
@section('title')
Edit Data Keuangan
@endsection

@section('content')
<div class="content">
    <form method="POST" action="{{url ('/dashboard/keuangan/'.$task->id)}}">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $task->created_at->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="pemasukan" class="form-label">Pemasukan</label>
            <input type="number" class="form-control" id="pemasukan" name="pemasukan" value="{{ $task->pemasukan }}" required>
        </div>

        <div class="mb-3">
            <label for="pengeluaran" class="form-label">Pengeluaran</label>
            <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ $task->pengeluaran }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection