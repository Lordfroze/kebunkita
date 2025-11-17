@extends('layouts.app')
@section('title')
Hasil Kalkulator Perdagangan
@endsection

@section('content')
<div class="container mt-4">
    <h2>Hasil Kalkulator Perdagangan</h2>
    <p>Tanggal: {{ $tanggal }}</p>
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
</div>

<div class="container text-left">
    <div class="row">
        <div class="col">
            <a href="{{ url('dashboard/perdagangan/kalkulator') }}" class="btn btn-primary mt-3">Kembali ke Kalkulator</a>
            <a href="{{ route('kalkulator.download', ['results' => json_encode($results)]) }}"
                class="btn btn-danger mt-3">
                Download PDF
            </a>
        </div>
    </div>
</div>
@endsection