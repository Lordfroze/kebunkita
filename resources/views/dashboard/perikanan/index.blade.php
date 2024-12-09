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
@endsection