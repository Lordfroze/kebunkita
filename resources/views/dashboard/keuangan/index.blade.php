@extends('layouts.app')
@section('title')
Dashboard Keuangan
@endsection

@section('content')
<!-- Main content -->
@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif


<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-4">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            <p>Pemasukan</p>
          </div>
          <div class="icon">
            <i class="fas fa-hand-holding-heart"></i>
          </div>
          <a href="{{ url('dashboard/perikanan/kolam_timur') }}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            <p>Pengeluaran</p>
          </div>
          <div class="icon">
            <i class="fas fa-hand-holding-heart"></i>
          </div>
          <a href="{{ url('/dashboard/perikanan/kolam_barat') }}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</h3>
            <p>Total Keseluruhan</p>
          </div>
          <div class="icon">
            <i class="fas fa-fish"></i>
          </div>
          <a href="{{ url('/dashboard/perikanan/jumlah_ikan') }}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    </div> <!-- <div class="row"> -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="content">
  <h2>Tabel Perikanan</h1>

    <a class="btn btn-success" href="{{ url('dashboard/keuangan/create') }}">+ Tambah Data</a>
    <div class="table-responsive mt-2">
      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Total Keseluruhan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- key adalah variabel yang secara otomatis disediakan oleh laravel  saat menggunakan direktif foreach -->
          @foreach($tasks as $key => $task)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
            <td>Rp {{ number_format($task->pemasukan, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($task->pengeluaran, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            <td>
              <a class="btn btn-primary btn-sm" href="{{ url('dashboard/keuangan/' . $task->id) }}" role="button">View</a>
              <a class="btn btn-info btn-sm" href="{{ url('dashboard/keuangan/' . $task->id . '/edit') }}" role="button">Edit</a>
              <form action="{{ url('dashboard/keuangan/' . $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin ingin menghapus data?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
{{ $tasks->links('pagination::bootstrap-4') }}

@endsection