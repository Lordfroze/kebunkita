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
          <a href="#" class="small-box-footer">
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
          <a href="#" class="small-box-footer">
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
          <a href="{{ url('/dashboard/keuangan/') }}" class="small-box-footer">
            Tampilkan semua <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    </div> <!-- <div class="row"> -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="content">
  <!-- Filter Form -->
  <form method="GET" action="{{ url ('/dashboard/keuangan') }}">
    <label>Dari:</label>
    <input type="date" name="start_date" value="{{ request('start_date') }}">

    <label>Sampai:</label>
    <input type="date" name="end_date" value="{{ request('end_date') }}">

    <button type="submit">Filter</button>
    <a href="{{ url('/dashboard/keuangan/export') }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}"
      class="btn btn-success">
      Download Excel
    </a>
  </form>
  <!-- End of Filter Form-->

  <!-- chart -->
  <!-- Doughnut Chart -->
  <div style="width: 350px; margin-bottom: 30px;">
    <canvas id="doughnutChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const start = "{{ request('start_date') }}";
    const end = "{{ request('end_date') }}";
    console.log("START:", start, "END:", end);

    fetch(`{{ url('/dashboard/keuangan/chart-data') }}?start_date=${start}&end_date=${end}`)
      .then(res => res.json())
      .then(data => {
        const labels = ["Pemasukan", "Pengeluaran"];
        const values = [data.pemasukan, data.pengeluaran];
        const colors = ["#4CAF50", "#F44336"];

        const ctx = document.getElementById('doughnutChart').getContext('2d');

        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels,
            datasets: [{
              data: values,
              backgroundColor: colors
            }]
          }
        });
      });
  </script>
  <!-- end chart -->


  <h2>Tabel Keuangan</h1>

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
<!-- Pagination agar filter tetap terjaga -->
{{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}

<!-- {{ $tasks->links('pagination::bootstrap-4') }} -->

@endsection