@extends('layouts.app')
@section('title')
Perikanan
@endsection

@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
        <div class="small-box bg-gradient-warning">
          <div class="inner">
            <h3>18</h3>
            <p>Total Pakan Kolam Timur</p>
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
            <h3>15</h3>
            <p>Total Pakan Kolam Barat</p>
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

<div>
<h1>Tabel Perikanan</h1>
<a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Tambah Data</a>
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Lokasi</th>
            <th>Biaya</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
      <!-- key adalah variabel yang secara otomatis disediakan oleh laravel  saat menggunakan direktif foreach -->
      @foreach($tasks as $key => $task)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ date("d M Y", strtotime($task->created_at)) }}</td>
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
@endsection

<!-- <div class="container">
  <h1>Contoh dari Database</h1><a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Buat Postingan</a>
  <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ Str::limit($post->content, 100) }}</td>
                <td>{{ date("d M Y H:i", strtotime($post->created_at)) }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ url('dashboard/perikanan/' . $post->id) }}" role="button">View</a>
                    <a class="btn btn-info btn-sm" href="{{ url('dashboard/perikanan/' . $post->id . '/edit') }}" role="button">Edit</a>
                    <form action="{{ url('dashboard/perikanan/' . $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin ingin menghapus data?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> -->