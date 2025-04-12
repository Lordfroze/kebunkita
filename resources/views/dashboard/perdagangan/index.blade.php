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
            <p>Jumlah Items</p>
          </div>
          <div class="icon">
            <i class="fas fa-hand-holding-heart"></i>
          </div>
          <a href="{{ url('#') }}" class="small-box-footer">
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
          <a href="{{ url('#') }}" class="small-box-footer">
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
          <a href="{{ url('#') }}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    </div> <!-- <div class="row"> -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="content">
  <h2>Tabel Perdagangan</h1>

    <a class="btn btn-success" href="{{ url('dashboard/perdagangan/create') }}">+ Tambah Data</a>
    <a class="btn btn-success" href="{{ url('dashboard/perdagangan/kalkulator') }}">+ kalkulator</a>
    <div class="table-responsive mt-2">
      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stock</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- key adalah variabel yang secara otomatis disediakan oleh laravel  saat menggunakan direktif foreach -->
          @foreach($items as $key => $item)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
            <td>{{ $item->stock }}</td>
            <td>
              <a class="btn btn-primary btn-sm" href="{{ url('dashboard/perdagangan/' . $item->id) }}" role="button">View</a>
              <a class="btn btn-info btn-sm" href="{{ url('dashboard/perdagangan/' . $item->id . '/edit') }}" role="button">Edit</a>
              <form action="{{ url('dashboard/perdagangan/' . $item->id) }}" method="POST" style="display:inline;">
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

{{ $items->links('pagination::bootstrap-4') }}

@endsection