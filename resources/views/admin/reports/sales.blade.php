@extends('layouts.admin')

@section('content')
    <h1>Laporan Penjualan</h1>
  <div class="card p-4" style="background-color: #B0E0E6">
    <table class="table table-bordered" style="background-color: white;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
             <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->produk->name}}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->price }}</td>
                <td>{{ $sale->created_at->format('d-m-Y') }}</td>
             </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection