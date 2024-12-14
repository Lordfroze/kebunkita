@extends('layouts.app')
@section('title')
Dashboard Perikanan
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
      <div class="col-lg-3">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>{{$jumlahPakanKolamTimur}}</h3>
            <p>Jumlah Pakan Kolam Timur</p>
          </div>
          <div class="icon">
            <i class="fas fa-hand-holding-heart"></i>
          </div>
          <a href="#" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>{{$jumlahPakanKolamBarat}}</h3>
            <p>Jumlah Pakan Kolam Barat</p>
          </div>
          <div class="icon">
            <i class="fas fa-hand-holding-heart"></i>
          </div>
          <a href="#" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>


      <!-- /.col-md-6 -->
      <div class="col-lg-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>3000</h3>
            <p>Jumlah Ikan</p>
          </div>
          <div class="icon">
            <i class="fas fa-fish"></i>
          </div>
          <a href="#" class="small-box-footer">
            Informasi Ikan <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
  
    </div> <!-- <div class="row"> -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="content">
<h2>Tabel Perikanan</h1>
<a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Tambah Data</a>
<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Lokasi</th>
            <th>Biaya</th>
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
            <td>{{ $task->kegiatan }}</td>
            <td>{{ $task->lokasi }}</td>
            <td>Rp {{ number_format($task->biaya, 0, ',', '.') }}</td>
            <td >Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
            <td>
                    <a class="btn btn-primary btn-sm" href="{{ url('dashboard/perikanan/' . $task->id) }}" role="button">View</a>
                    <a class="btn btn-info btn-sm" href="{{ url('dashboard/perikanan/' . $task->id . '/edit') }}" role="button">Edit</a>
                    <form action="{{ url('dashboard/perikanan/' . $task->id) }}" method="POST" style="display:inline;">
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
@endsection