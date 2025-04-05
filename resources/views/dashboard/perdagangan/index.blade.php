@extends('layouts.app')
@section('title')
Dashboard Perdagangan
@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-4">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>20</h3>
            <p>Jumlah Stock Gudang</p>
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
            <h3>10</h3>
            <p>Jumlah Stock Toko</p>
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
            <h3>100</h3>
            <p>Penjualan</p>
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
  <h2>Tabel Perdagangan</h1>

    <a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Tambah Data</a>
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
          @foreach($items as $key => $item)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
            <td>{{ $item->kode_barang }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</td>
            <td>
              <a class="btn btn-primary btn-sm" href="{{ url('dashboard/perikanan/' . $item->id) }}" role="button">View</a>
              <a class="btn btn-info btn-sm" href="{{ url('dashboard/perikanan/' . $item->id . '/edit') }}" role="button">Edit</a>
              <form action="{{ url('dashboard/perikanan/' . $item->id) }}" method="POST" style="display:inline;">
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


<!-- @foreach($item as $key => $item)
{{$items}}
@endforeach -->


@endsection