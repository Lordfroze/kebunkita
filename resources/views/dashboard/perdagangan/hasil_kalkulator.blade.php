@extends('layouts.app')
@section('title')
Hasil Kalkulator Perdagangan
@endsection

@section('content')
<div class="container mt-4">
    <h2>Hasil Kalkulator Perdagangan</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah Terjual</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>{{ $result['name'] }}</td>
                    <td>{{ $result['quantity'] }}</td>
                    <td>{{ number_format($result['price'], 0, ',', '.') }}</td>
                    <td>{{ number_format($result['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Keseluruhan</th>
                    <th>{{ number_format(array_sum(array_column($results, 'total')), 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <a href="{{ url('dashboard/perdagangan/kalkulator') }}" class="btn btn-primary mt-3">Kembali ke Kalkulator</a>
</div>
@endsection