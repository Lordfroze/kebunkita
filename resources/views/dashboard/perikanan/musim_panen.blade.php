@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Harvest Season {{ $season }}</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Biaya</h5>
                    <p class="card-text">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Ikan</h5>
                    <p class="card-text">{{ number_format($jumlahIkan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Kegiatan</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Biaya</th>
                            <th>Jumlah Ikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $task->kegiatan }}</td>
                            <td>{{ $task->lokasi }}</td>
                            <td>Rp {{ number_format($task->biaya, 0, ',', '.') }}</td>
                            <td>{{ number_format($task->jumlah_ikan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $tasks->links() }}
        </div>
    </div>
</div>
@endsection
