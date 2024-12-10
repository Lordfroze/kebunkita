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
      <!-- /.col-md-6 -->
    </div>
    {{-- table --}}
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Kegiatan</th>
          <th>Biaya</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      <tbody>
        <!-- data 1 -->
        <tr>
          <td>12 Desember 2022</td>
          <td>Pembelian pakan</td>
          <td>Rp. 378.000</td>
          <td>Rp. 378.000</td>
          <td>
            <a href="#" class="btn btn-info">Edit</a>
            <a href="#" class="btn btn-danger">Hapus</a>
          </td>
        </tr>
        <!-- data 2 -->
        <tr>
          <td>25 Desember 2022</td>
          <td>Pembelian pakan</td>
          <td>Rp. 378.000</td>
          <td>Rp. 756.000</td>
          <td>
            <a href="#" class="btn btn-info">Edit</a>
            <a href="#" class="btn btn-danger">Hapus</a>
          </td>
        <tr>
      </tbody>
    </table><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="container">
    <h1>Blog Codepolitan
    <a class="btn btn-success" href="{{ url('dashboard/perikanan/create') }}">+ Buat Postingan</a>
    </h1>
    <!-- card -->
    @foreach($posts as $post) 
    <div class="card mb-3">
        <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <p class="card-text">{{ $post->content}}</p>
        <p class="card-text"><small class="text-body-secondary">Last updated {{date("d M Y H:i", strtotime($post->created_at))}} ago</small></p>
        <a class="btn btn-primary" href="{{ url('dashboard/perikanan/' . $post->id) }}"  role="button">Selengkapnya</a>
        </div>
    </div>
    @endforeach        
</div>

<div class="container">
  <h1>Tabel dari Database</h1>
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
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection