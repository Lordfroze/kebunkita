@extends('layouts.app')
@section('title')
kalkulator perdagangan
@endsection

@section('content')
<div class="container mt-4">
  <h2>Kalkulator Perdagangan</h2>
  <form action="{{ url('dashboard/perdagangan/calculate') }}" method="POST">
    @csrf
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama Barang</th>
            <th>Jumlah Terjual</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $item)
          <tr>
            <td>{{ $item->nama_barang }}</td>
            <td>
              <input type="number"
                class="form-control"
                name="jumlah_terjual[{{ $item->id }}]"
                min="0"
                value="{{ old('jumlah_terjual.'.$item->id, 0) }}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Hitung</button>
    <button type="submit" class="btn btn-secoundary mt-3"><a href="{{url ('dashboard/perdagangan')}}">Kembali</a></button>
  </form>
</div>

<div class="table-responsive mt-4">
  <!-- ... existing table code ... -->
</div>
@endsection