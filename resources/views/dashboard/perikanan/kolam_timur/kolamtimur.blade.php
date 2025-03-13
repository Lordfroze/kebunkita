@extends('layouts.app')
@section('title')
Detail Kolam Timur
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
      <!-- chart -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Grafik Bulanan Kolam Timur</h3>
          </div>
          <div class="card-body">
            <canvas id="kolamTimurChart" height="100"></canvas>
          </div>
        </div>
      </div>
    
      <div class="col-lg-3">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fa-solid fa-cookie-bite"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Jumlah Pakan Kolam Timur</span>
            <span class="info-box-number">{{$jumlahPakanKolamTimur}}</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-fish"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Jumlah Ikan Kolam Timur</span>
            <span class="info-box-number">{{$jumlah_ikan_timur}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="info-box bg-blue">
          <span class="info-box-icon"><i class="fa-solid fa-rupiah-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Jumlah Biaya Kolam Timur</span>
            <span class="info-box-number">Rp {{ number_format($totalBiayaKolamTimur, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-box bg-blue">
          <span class="info-box-icon"><i class="fa-solid fa-rupiah-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Jumlah Biaya Panen Kolam Timur</span>
            <span class="info-box-number">Rp {{ number_format($totalBiayaKolamTimurPanen, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      <div class="col-lg-4">  
        <div class="info-box bg-blue">
          <span class="info-box-icon"><i class="fa-solid fa-rupiah-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Selisih Biaya Kolam Timur</span>
            <span class="info-box-number">Rp {{ number_format($selisihBiayaPanen, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

    </div>
    
  </div>

  <h2>Tabel Perikanan</h1>

    <div class="row">
      <div class="col-lg-12">
        <a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Tambah Data</a>
      </div>
    </div>

    <div class="table-responsive mt-2">
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
            <td>Rp {{ number_format($totalBiayaKolamTimur, 0, ',', '.') }}</td>
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

    <div class="mb-2">
      <!-- Delete Seluruh Data Kolam timur -->
      <form action="{{ route('perikanan.kolam_timur.deleteAll') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all perikanan data for Kolam Timur? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Seluruh Data Kolam Timur</button>
      </form>
    </div>
</div>


{{ $tasks->links('pagination::bootstrap-4') }}

<!-- script chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('kolamTimurChart');
    if (ctx) {
      var chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: @json($chartData['labels']),
          datasets: [{
            label: 'Total Expenses',
            data: @json($chartData['data']),
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'y',
          scales: {
            x: {
              beginAtZero: true,
              ticks: {
                callback: function(value, index, values) {
                  return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
              }
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });
    }
  });
</script>
@endsection